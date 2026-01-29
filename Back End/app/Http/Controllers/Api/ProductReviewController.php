<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    // ⭐ Add Rating + Review (Single Modal)
    public function addRatingReview(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'min:1'],
            'rating_amount'          => 'required|numeric|min:1|max:5',
            'product_review_details' => 'nullable|string|max:500',
        ]);
        $customerId = Auth::id();

        // ❌ Prevent duplicate review for same product
        $existing = ProductReview::where('customer_id', $customerId)
            ->where('product_id', $request->product_id)
            ->where('deleted', 0)
            ->first();

        if ($existing) {
            return response()->json([
                'status'  => false,
                'message' => 'You have already submitted a review for this product.',
            ], 409);
        }

        // ⭐ SAVE RATING
        $rating = ProductRating::create([
            'customer_id'   => $customerId,
            'product_id'    => $request->product_id,
            'rating_amount' => $request->rating_amount,  // ✅ FIXED
            'status'        => 1,
            'created_by'    => $customerId,
        ]);

        // ⭐ SAVE REVIEW (WORKS)
        $review = ProductReview::create([
            'customer_id'            => $customerId,
            'product_id'             => $request->product_id,
            'product_review_details' => $request->product_review_details,
            'rating_id'              => $rating->id,
            'status'                 => 1,
            'created_by'             => $customerId,
        ]);


        return response()->json([
            'status'  => true,
            'message' => "Your rating & review has been submitted successfully!",
            'rating'  => $rating,
            'review'  => $review
        ]);
    }

    // ⭐ Get All Reviews for One Product
    public function productReviews($productId)
    {
        $reviews = ProductReview::with(['rating', 'customer'])
            ->where('product_id', $productId)
            ->where('deleted', 0)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status'   => true,
            'total'    => $reviews->count(),
            'reviews'  => $reviews
        ]);
    }

    // ⭐ Get Logged-in Customer Reviews
    public function myReviews()
    {
        $reviews = ProductReview::with(['rating', 'product'])
            ->where('customer_id', Auth::id())
            ->where('deleted', 0)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status'  => true,
            'reviews' => $reviews
        ]);
    }
}
