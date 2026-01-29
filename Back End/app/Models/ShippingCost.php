<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
    use HasFactory;

    protected $fillable = ['division_id', 'district_id', 'inside_price', 'outside_price'];

    // Shipping cost belongs to division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // Shipping cost belongs to district
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
