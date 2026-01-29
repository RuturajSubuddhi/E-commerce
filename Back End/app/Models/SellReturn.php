<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class SellReturn extends Model
{
    protected $table = 'sell_returns';
 
    protected $fillable = [
        'sell_id',
        'user_id',
        'reason',
        'comment',
        'image',
        'status',
    ];
 
    // Timestamps are true because migration uses $table->timestamps()
    public $timestamps = true;
 
    // Relationship with Sell (Order)
    public function order()
    {
        return $this->belongsTo(Sell::class, 'order_id');
    }
 
    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}