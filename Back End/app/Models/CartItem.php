<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'add_to_cart_lists'; // ✅ important

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'offer_id',
        'offer_discount',
        'offer_exp_date',
        'date',
        'status',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}