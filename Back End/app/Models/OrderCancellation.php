<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class OrderCancellation extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'sell_id',
        'user_id',
        'reason',
        'comment',
        'requested_at',
        'status',
        'approved_at',
        'rejected_at'
    ];
 
    public function order()
    {
        return $this->belongsTo(Sell::class, 'sell_id');
    }
}