<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'type',
    ];
}