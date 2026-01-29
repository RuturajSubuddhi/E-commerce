<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishListResource;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function addWishList(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'user_id'    => 'required|integer',
        ]);

        $exists = Wishlist::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($exists) {
            return response()->json([
                'status' => 400,
                'msg' => 'Already in wishlist'
            ], 400);
        }

        Wishlist::create([
            'user_id'    => $request->user_id,
            'product_id' => $request->product_id,
            'date'       => Carbon::now(),
        ]);

        return response()->json([
            'status' => 200,
            'msg' => 'WishList Added Successfully'
        ]);
    }


    public function getWishList(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        $items = Wishlist::with('product')
            ->where('user_id', $request->user_id)
            ->get();

        return response()->json([
            'status' => 200,
            'wishlist' => $items
        ]);
    }


    public function count(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        return Wishlist::where('user_id', $request->user_id)->count();
    }


    public function removeWishList(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|integer',
            'product_id' => 'required|integer'
        ]);

        Wishlist::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'Removed from wishlist'
        ]);
    }
}
