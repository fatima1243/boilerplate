<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable, HasApiTokens;
    protected $appends = ['role'];
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
    public function getRoleAttribute()
    {
        return 1; // Role for driver
    }

}
