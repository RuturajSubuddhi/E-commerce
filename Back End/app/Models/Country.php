<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    // A country has many divisions (states/provinces)
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    // Optional: shipping costs through divisions
    public function shippingCosts()
    {
        return $this->hasManyThrough(ShippingCost::class, Division::class);
    }
}
