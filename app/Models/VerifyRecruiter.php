<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyRecruiter extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'recruiter_id',
    ];
    public function recruiter(){
        return $this->belongsTo(Recruiter::class);
    }
}
