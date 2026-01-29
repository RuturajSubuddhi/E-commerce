<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;
use App\Models\CompanyInfo;
use App\Mail\ConfirmOrderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderStatusMail; // Create a new mailable for status updates


class OrderController extends Controller
{
    public function orderAll(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'All Order';
    }

    public function orderPending(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Pending Order';
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 0, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }

    public function orderProcessing(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Processing Order';
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 1, 'deleted' => 0])->get();

        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }

    public function orderOnTheWay(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Order On The Way ';
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 2, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }
    //     public function orderOutForDelivery(Request $request)
    // {
    //     $common_data = new \stdClass();
    //     $common_data->title = 'Out For Delivery';

    //     $orderList = Sell::where([
    //         'sell_type' => 2,
    //         'order_status' => 3,   // "Out for Delivery" status
    //         'deleted' => 0
    //     ])->get();

    //     return view('adminPanel.order.pending_order')
    //         ->with(compact('orderList', 'common_data'));
    // }


    public function orderCancelRequest(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Order Canceled Request';
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 3, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }

    public function orderCancelAccept(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Order Canceled Accepted';
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 4, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }

    public function orderCancelCompleted(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Canceled Process Completed';
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 5, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }


    public function OrderComplete(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Completed Order';
        $common_data = new Array_();
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 6, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }

    public function OrderOutForDelivery(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Out For Delivery Order';
        $common_data = new Array_();
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 7, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }

    public function OrderReturnRequest(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Return Request Order';
        $common_data = new Array_();
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 8, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }
    public function OrderReturnAccepted(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Return Request Accept Order';
        $common_data = new Array_();
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 9, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }
    public function OrderReturnRejected(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Return Request Rejected Order';
        $common_data = new Array_();
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 10, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }
    public function OrderRefundCompleted(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Refund Completed Order';
        $common_data = new Array_();
        $orderList = Sell::where(['sell_type' => 2, 'order_status' => 11, 'deleted' => 0])->get();
        return view('adminPanel.order.pending_order')->with(compact('orderList', 'common_data'));
    }


    // public function SellOrderDetails(Request $request)
    // {
    //     $orderList = Sell::with('customer')
    //         ->with('sellDetail')
    //         ->with('orderAddress')
    //         ->with('paymentInfo')
    //         ->find($request->id);
    //     return view('adminPanel.order._order_details')->with(compact('orderList'))->render();
    // }
    public function sellOrderDetails(Request $request)
    {
        $orderList = Sell::with(['customer', 'sellDetail', 'orderAddress', 'paymentInfo'])
            ->find($request->id);

        return view('adminPanel.order._order_details')
            ->with(compact('orderList'))
            ->render();
    }

    // public function OrderStatusUpdate(Request $request)
    // {
    //     $info = Sell::where('id', $request->order_id)->update(['order_status' => $request->status]);
    //     return redirect()->back()->with('success', 'Successfully Order Status Updated');
    // }

    // public function OrderStatusUpdate(Request $request)
    // {
    //     $request->validate([
    //         'order_id' => 'required|exists:sells,id',
    //         'status' => 'required|integer|in:0,1,2,3,4,5,6,7,8,9,10,11',
    //     ]);

    //     $order = Sell::with(['user', 'sellDetail', 'orderAddress'])->find($request->order_id);

    //     if (!$order) {
    //         return redirect()->back()->with('error', 'Order not found');
    //     }

    //     $order->order_status = $request->status;
    //     $order->save();

    //     $company = CompanyInfo::first();
    //     $customerEmail = $order->user->email ?? null;

    //     if ($customerEmail && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
    //         try {
    //             Mail::to($customerEmail)->send(new OrderStatusMail($order, $company));
    //             Log::info("Order status email sent to: " . $customerEmail);
    //         } catch (\Exception $e) {
    //             Log::error("Order status email failed: " . $e->getMessage());
    //         }
    //     } else {
    //         Log::warning("Skipped sending email. Invalid email: " . $customerEmail);
    //     }

    //     return redirect()->back()->with('success', 'Order status updated and email sent successfully!');
    // }

    public function OrderStatusUpdate(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:sells,id',
        'status' => 'required|integer|in:0,1,2,3,4,5,6,7,8,9,10,11',
    ]);

    $order = Sell::with('user')->find($request->order_id);

    if (!$order) {
        return redirect()->back()->with('error', 'Order not found');
    }

    $now = now();

    // Status timestamps
    $statusTimestamps = [
        0 => 'placed_at',
        1 => 'processing_at',
        2 => 'on_the_way_at',
        7 => 'out_for_delivery_at',
        6 => 'delivered_at',
        3 => 'cancel_requested_at',
        4 => 'cancel_accepted_at',
        5 => 'cancel_completed_at',
        8 => 'return_requested_at',
        9 => 'return_accepted_at',
        10 => 'return_rejected_at',
        11 => 'refund_completed_at',
    ];

    if (isset($statusTimestamps[$request->status])) {
        $order->{$statusTimestamps[$request->status]} = $now;
    }

    $order->order_status = $request->status;
    $order->save();

    $company = CompanyInfo::first();
    $adminEmail = config('mail.admin_email');
    $customerEmail = $order->user->email ?? null;

    try {
        // Mail to Customer
        if ($customerEmail && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::to($customerEmail)
                ->send(new OrderStatusMail($order, $company));
        }

        // Mail to Admin
        if ($adminEmail) {
            Mail::to($adminEmail)
                ->send(new OrderStatusMail($order, $company));
        }

    } catch (\Exception $e) {
        Log::error('Order mail failed: ' . $e->getMessage());
    }

    return redirect()->back()
        ->with('success', 'Order status updated & mail sent to customer and admin!');
}

    public function updateOrderNote(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:sells,id',
            'note' => 'nullable|string',
        ]);

        // Find the order address related to the order
        $orderAddress = \App\Models\SellOrderAddress::where('sell_id', $request->order_id)->first();

        if (!$orderAddress) {
            return response()->json(['message' => 'Order address not found.'], 404);
        }

        $orderAddress->note = $request->note;
        $orderAddress->save();

        return response()->json(['message' => 'Order note updated successfully']);
    }
   public function confirmOrder(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:sells,id',
    ]);

    $order = Sell::with('user')->find($request->order_id);

    if (!$order) {
        return response()->json(['status' => false, 'message' => 'Order not found'], 404);
    }

    if ($order->order_status == 1) {
        return response()->json(['status' => false, 'message' => 'Order already confirmed']);
    }

    $order->order_status = 1;
    $order->processing_at = now();
    $order->save();

    $adminEmail = config('mail.admin_email');

    try {
        // Customer
        Mail::to($order->user->email)
            ->send(new ConfirmOrderMail($order));

        // Admin
        Mail::to($adminEmail)
            ->send(new ConfirmOrderMail($order));

    } catch (\Exception $e) {
        Log::error('Confirm order mail failed: ' . $e->getMessage());
    }

    return response()->json([
        'status' => true,
        'message' => 'Order confirmed & email sent to customer and admin!'
    ]);
}

}
