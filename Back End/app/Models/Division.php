<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'name'];

    // Division belongs to a country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Division has many districts
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    // Division has many cities
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    // Division has many shipping costs
    public function shippingCosts()
    {
        return $this->hasMany(ShippingCost::class);
    }
}
