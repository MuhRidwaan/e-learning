<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syllabus_id')->nullable()->constrained('syllabus')->nullOnDelete();
            $table->foreignId('instructor_id')->constrained('users');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();
            $table->unsignedInteger('duration_weeks')->nullable();
            $table->unsignedInteger('max_students')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['active', 'completed', 'dropped'])->default('active');
            $table->timestamp('enrolled_at')->nullable()->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['course_id', 'student_id']);
        });

        Schema::create('course_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('review')->nullable();
            $table->timestamps();
            $table->unique(['course_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_ratings');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('courses');
    }
};
