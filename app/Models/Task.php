<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $appends = ['formated_created_at', 'is_expired'];

    protected $fillable = [
        'title',
        'service_type',
        'service_date',
        'service_duration',
        'additional_details',
        'pickup_location',
        'dropoff_location',
        'pickup_lat',
        'pickup_long',
        'drop_lat',
        'drop_long',
        'final_budget',
        'distance',
        'recruiter_id',
        'is_assigned'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function taskGalleries()
    {
        return $this->hasMany(TaskGallery::class, 'task_id', 'id')->whereType(1)->latest();
    }

    public function video()
    {
        return $this->hasOne(TaskGallery::class, 'task_id', 'id')->where('type', 0)->latest();
    }

    public function image()
    {
        return $this->hasOne(TaskGallery::class, 'task_id', 'id')->where('type', 1)->latest();
    }

    public function  getformatedCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function  getIsExpiredAttribute()
    {
        return now()->format('Y-m-d') > $this->expected_date ? true : false;
    }

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class);
    }

    public function biddings()
    {
        return $this->hasMany(Bidding::class, 'task_id', 'id');
    }

    public function isBid()
    {
        return $this->hasOne(Bidding::class, 'task_id', 'id')->where('driver_id', auth()->id());
    }

    public function minBid()
    {
        return $this->hasOne(Bidding::class, 'task_id', 'id')->orderBy('price', 'asc');
    }

    public function myLatestBidd()
    {
        return $this->hasOne(Bidding::class, 'task_id', 'id')->where('user_id', auth()->id());
    }
}
