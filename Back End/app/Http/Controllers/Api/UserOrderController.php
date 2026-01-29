<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserOrderDetailsResource;
use App\Http\Resources\UserOrderListResource;
use App\Models\Sell;
use App\Models\Sell_details;
use App\Models\OrderCancellation;
use App\Models\SellReturn;
use App\Models\CompanyInfo;
use App\Models\SellOrderAddress;
use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;

/**
 * USER MAILS
 */

use App\Mail\OrderMail;
use App\Mail\CancelOrderMail;
use App\Mail\ReturnRequestMail;

/**
 * ADMIN MAILS
 */

use App\Mail\Admin\OrderPlacedMail;
use App\Mail\Admin\OrderCancelledMail;
use App\Mail\Admin\OrderReturnedMail;

class UserOrderController extends Controller
{
    /**
     * ------------------------------------
     * PLACE ORDER
     * ------------------------------------
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            "cart_items" => "required|array",
            "cart_items.*.product_id" => "required|integer",
            "cart_items.*.unit_sell_price" => "required|numeric",
            "cart_items.*.sale_quantity" => "required|numeric|min:1",

            "shipping_phone" => "required|string",
            "shipping_address" => "required|string",
            "shipping_division" => "required|integer",
            "shipping_district" => "required|integer",
            "shipping_country" => "required|string",
            "shipping_zip" => "required|string",

            "payment_method" => "required|string",
            "total_amount" => "required|numeric"
        ]);

        $subTotal = 0;
        foreach ($request->cart_items as $item) {
            $subTotal += $item['unit_sell_price'] * $item['sale_quantity'];
        }

        // Promo
        $discount = 0;
        $promoCode = null;

        if ($request->promo_code) {
            $promo = \App\Models\PromoCode::where('code', $request->promo_code)
                ->where('status', 1)
                ->first();

            if ($promo) {
                if ($promo->expires_at && now()->gt($promo->expires_at)) {
                    return response()->json(['status' => false, 'message' => 'Promo code expired']);
                }

                if ($subTotal < $promo->min_order_amount) {
                    return response()->json(['status' => false, 'message' => 'Minimum order amount not met']);
                }

                $discount = $promo->discount_type == 1
                    ? $promo->discount_value
                    : min(($subTotal * $promo->discount_value) / 100, $promo->max_discount ?? PHP_INT_MAX);

                $promoCode = $promo->code;
            }
        }

        $shippingCost = $request->shipping_cost ?? 0;
        $totalPayable = $subTotal - $discount + $shippingCost;

        // 🔒 Capture emails BEFORE transaction
        $userEmail   = Auth::user()->email;
        $adminEmails = Admin::where('status', 1)->pluck('email')->toArray();

        DB::beginTransaction();

        try {
            $order = Sell::create([
                "invoice_id" => "INV-" . time(),
                "customer_id" => Auth::id(),
                "user_id" => Auth::id(),
                "sell_type" => 2,
                "total_payable_amount" => $totalPayable,
                "order_status" => 0,
                "payment_type" => $request->payment_method,
                "sub_total" => $subTotal,
                "promo_code" => $promoCode,
                "promo_discount" => $discount,
                "total_discount" => $discount,
                "shipping_cost" => $shippingCost,
                "date" => now(),
            ]);

            foreach ($request->cart_items as $item) {
                Sell_details::create([
                    "sell_id" => $order->id,
                    "product_id" => $item['product_id'],
                    "unit_sell_price" => $item['unit_sell_price'],
                    "sale_quantity" => $item['sale_quantity'],
                    "total_payable_amount" => $item['unit_sell_price'] * $item['sale_quantity']
                ]);
            }

            SellOrderAddress::create([
                "sell_id" => $order->id,
                "user_id" => Auth::id(),
                "shipping_phone" => $request->shipping_phone,
                "shipping_address" => $request->shipping_address,
                "shipping_division" => $request->shipping_division,
                "shipping_district" => $request->shipping_district,
                "shipping_country" => $request->shipping_country,
                "shipping_zip" => $request->shipping_zip,
                "note" => $request->note ?? null,
            ]);

            DB::commit();

            // ✅ Send mails AFTER COMMIT safely
            DB::afterCommit(function () use ($order, $userEmail, $adminEmails) {
                try {
                    $orderData = Sell::with([
                        'user',
                        'orderAddress',
                        'sellDetail.product'
                    ])->find($order->id);

                    $company = CompanyInfo::first();

                    // USER
                    Mail::to($userEmail)
                        ->queue(new OrderMail($orderData, $company));

                    // ADMIN
                    if (!empty($adminEmails)) {
                        Mail::to($adminEmails)
                            ->queue(new OrderPlacedMail($orderData, $company));
                    }
                } catch (\Throwable $e) {
                    Log::error('Post order mail error', ['error' => $e->getMessage()]);
                }
            });

            return response()->json([
                "status" => true,
                "message" => "Order placed successfully",
                "order_id" => $order->id,
                "invoice_id" => $order->invoice_id
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order failed', ['error' => $e->getMessage()]);
            return response()->json(["status" => false, "message" => "Order failed"]);
        }
    }

    /**
     * ------------------------------------
     * CANCEL ORDER
     * ------------------------------------
     */
    public function cancel(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:sells,id',
            'reason' => 'required|string',
            'comment' => 'nullable|string',
        ]);

        $order = Sell::find($request->order_id);
        if ($order->order_status == 3) {
            return response()->json(['status' => false, 'message' => 'Already cancelled']);
        }

        OrderCancellation::create([
            'sell_id' => $order->id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'comment' => $request->comment,
            'status' => 0
        ]);

        $order->update(['order_status' => 3]);

        $company = CompanyInfo::first();
        $adminEmails = Admin::where('status', 1)->pluck('email')->toArray();

        Mail::to(Auth::user()->email)
            ->queue(new CancelOrderMail($order, $request->reason, $request->comment, $company));

        if (!empty($adminEmails)) {
            Mail::to($adminEmails)
                ->queue(new OrderCancelledMail($order, $request->reason, $request->comment, $company));
        }

        return response()->json(['status' => true, 'message' => 'Cancellation requested']);
    }

    /**
     * ------------------------------------
     * RETURN REQUEST
     * ------------------------------------
     */
    public function returnRequest(Request $request)
    {
        $request->validate([
            "order_id" => "required|exists:sells,id",
            "reason" => "required|string",
            "comment" => "nullable|string",
        ]);

        $order = Sell::where('id', $request->order_id)
            ->where('customer_id', Auth::id())
            ->first();

        if ($order->order_status != 6) {
            return response()->json(['status' => false, 'message' => 'Return allowed only after delivery']);
        }

        $return = SellReturn::create([
            "sell_id" => $order->id,
            "user_id" => Auth::id(),
            "reason" => $request->reason,
            "comment" => $request->comment,
            "status" => 0,
        ]);

        $order->update(['order_status' => 8]);

        $company = CompanyInfo::first();
        $adminEmails = Admin::where('status', 1)->pluck('email')->toArray();

        Mail::to(Auth::user()->email)
            ->queue(new ReturnRequestMail($order, $company, $return));

        if (!empty($adminEmails)) {
            Mail::to($adminEmails)
                ->queue(new OrderReturnedMail($order, $return, $company));
        }

        return response()->json(['status' => true, 'message' => 'Return request submitted']);
    }


    public function myOrders()
    {
        $orders = Sell::with(['sellDetail.product'])
            ->where('customer_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'orders' => UserOrderListResource::collection($orders)
        ]);
    }

    public function downloadInvoice($orderId)
    {
        $order = Sell::with(['customer', 'orderAddress', 'user', 'sellDetail.product'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->first();
 
        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }
 
        $company = CompanyInfo::first();
 
        $pdf = Pdf::loadView('adminPanel.order.order_invoice', [
            'order' => $order,
            'company' => $company
        ]);
 
        return $pdf->download('invoice_' . $order->invoice_id . '.pdf');
    }
}
