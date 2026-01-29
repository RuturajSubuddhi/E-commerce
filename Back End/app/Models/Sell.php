<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Sell extends Model
{
    use HasFactory;
 
    protected $fillable = [
        "customer_id",
        "user_id",
        "invoice_id",
        "sell_type",
        "sell_by",
        "bank_id",
        'sub_total',
        'promo_code',
        'promo_discount',
        "shipping_cost",
        "total_vat_amount",
        "total_discount",
        "total_payable_amount",
        "total_paid",
        "total_due",
        "order_status",
        "payment_type",
        "date",
        'processing_at',
        'on_the_way_at',
        'out_for_delivery_at',
        'delivered_at',
        'cancel_requested_at',
        'cancel_accepted_at',
        'cancel_completed_at',
        'return_requested_at',
        'return_accepted_at',
        'return_rejected_at',
        'refund_completed_at',
 
 
    ];
    public function customer()
    {
        return $this->belongsTo(PosCustomer::class, 'customer_id', 'id');
    }
    public function sellDetail()
    {
        return $this->hasMany(Sell_details::class, 'sell_id', 'id');
    }
 
    public function orderAddress()
    {
        return $this->hasOne(SellOrderAddress::class, 'sell_id', 'id');
    }
 
    public function paymentInfo()
    {
        return $this->hasOne(PaymentInfo::class, 'sell_id', 'id');
    }
 
    public function items()
    {
        return $this->hasMany(Sell_details::class, 'sell_id', 'id');
    }
 
    public function cancellation()
    {
        return $this->hasOne(OrderCancellation::class, 'sell_id');
    }
 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
 