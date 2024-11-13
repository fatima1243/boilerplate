<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Driver extends Model
{
    use HasFactory, SoftDeletes;
    protected $guard_name = 'driver';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'contact_no',
        'state_id',
        'city_id',
        'identity_card_front',
        'identity_card_back',
        'driving_lic_front',
        'driving_lic_back',
        'vehicle_insurance_policy',
        'vehicle_type',
        'vehicle_model  ',
        'year_of_production',
        'vehicle_plates',
        'driving_experience',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
