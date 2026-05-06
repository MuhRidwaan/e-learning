<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'syllabus_id',
        'instructor_id',
        'title',
        'description',
        'thumbnail',
        'status',
        'duration_weeks',
        'max_students',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'duration_weeks' => 'integer',
        'max_students' => 'integer',
    ];

    /**
     * Get the instructor of the course
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get all forum threads for the course
     */
    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class, 'course_id');
    }

    /**
     * Get all modules for this course, ordered by order column
     */
    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('order');
    }

    /**
     * Get all enrollments for this course
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Check if a specific user is enrolled in this course
     */
    public function isEnrolled(int $userId): bool
    {
        return DB::table('enrollments')
            ->where('course_id', $this->id)
            ->where('student_id', $userId)
            ->where('status', 'active')
            ->exists();
    }
}
