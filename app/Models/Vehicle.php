<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'vehicle_insurance',
        'vehicle_type',
        'vehicle_make_model',
        'year_of_production',
        'vehicle_color',
        'vehicle_plates',
        'traffic_accidents',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
