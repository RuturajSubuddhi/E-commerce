<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'division_id', 'district_id'];

    // City belongs to a division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // City belongs to a district
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
