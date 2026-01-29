<?php
 
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
 
class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
            'user_id'    => 'required|integer'
        ]);
 
        $quantity = $request->quantity ?? 1;
 
        $cartItem = CartItem::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();
 
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id'    => $request->user_id,
                'product_id' => $request->product_id,
                'quantity'   => $quantity,
                'date'       => now()->toDateString(),
                'status'     => 1,
                'deleted'    => 0,
            ]);
        }
 
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!'
        ]);
    }
 
 
    public function viewCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);
 
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user_id)
            ->where('deleted', 0)
            ->get();
 
        return response()->json([
            'success' => true,
            'cart' => $cartItems
        ]);
    }
 
 
    // public function removeFromCart(Request $request)
    // {
    //     $request->validate([
    //         'user_id'    => 'required|integer',
    //         'product_id' => 'required|integer'
    //     ]);
 
    //     $item = CartItem::where('user_id', $request->user_id)
    //         ->where('product_id', $request->product_id)
    //         ->where('deleted', 0)
    //         ->first();
 
    //     if (!$item) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Item not found in cart'
    //         ], 404);
    //     }
 
    //     $item->deleted = 1;
    //     $item->save();
 
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Item removed from cart'
    //     ]);
    // }
 
 
    // public function clearCart(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|integer'
    //     ]);
 
    //     CartItem::where('user_id', $request->user_id)
    //         ->update(['deleted' => 1]);
 
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Cart cleared successfully'
    //     ]);
    // }
 
    // Remove single item from cart
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|integer',
            'product_id' => 'required|integer'
        ]);
 
        $item = CartItem::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();
 
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        }
 
        $item->delete(); // hard delete
 
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }
 
    // Clear all items in cart for a user
    public function clearCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);
 
        CartItem::where('user_id', $request->user_id)->delete(); // hard delete all
 
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
}
 
 