<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $table = 'product_reviews';

    protected $fillable = [
        'customer_id',
        'product_id',
        'product_review_details',
        'rating_id',
        'status',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    public $timestamps = true;

    // ⭐ Review belongs to customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // ⭐ Review belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ⭐ Review has one rating
    public function rating()
    {
        return $this->belongsTo(ProductRating::class, 'rating_id', 'id');
    }
}
