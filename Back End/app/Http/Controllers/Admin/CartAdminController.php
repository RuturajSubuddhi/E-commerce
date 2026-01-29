<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartItem;

class CartAdminController extends Controller
{
    public function index()
    {
        // Get all cart items with user & product details
        $cartItems = CartItem::with(['user', 'product'])->get();

        return view('admin.cart.index', compact('cartItems'));
    }
}
