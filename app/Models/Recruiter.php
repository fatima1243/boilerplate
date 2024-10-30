<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;



class Recruiter extends Authenticatable
{

    use HasFactory, SoftDeletes, Notifiable, HasApiTokens;

    protected $guard_name = 'recruiter';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'postal_code',
        'email_verified_at',
        'deleted_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function verifyRecruiter()
    {
        return $this->hasOne(VerifyRecruiter::class);
    }
}

