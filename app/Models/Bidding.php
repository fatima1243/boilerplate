<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    use HasFactory;

    protected $fillable = ['driver_id', 'task_id', 'description', 'price', 'status'];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
