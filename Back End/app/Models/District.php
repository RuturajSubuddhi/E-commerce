<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['division_id', 'name'];

    // District belongs to a division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // District has many cities
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    // District has many shipping costs
    public function shippingCosts()
    {
        return $this->hasMany(ShippingCost::class);
    }
}
