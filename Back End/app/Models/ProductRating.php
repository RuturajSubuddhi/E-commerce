<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    protected $table = 'product_ratings';

    protected $fillable = [
        'customer_id',
        'product_id',
        'rating_amount',
        'status',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    public $timestamps = true;

    // ⭐ Rating belongs to a customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // ⭐ Rating belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ⭐ Link to review USING rating_id (SAFE)
    public function review()
    {
        return $this->hasOne(ProductReview::class, 'rating_id', 'id');
    }
}
