<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cnic_front',
        'cnic_back',
        'driving_license',
        'vehicle_insurance',
        'driver_id'
    ];
}
