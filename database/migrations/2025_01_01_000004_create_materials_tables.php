<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
            $table->index(['course_id', 'order']);
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('course_modules')->cascadeOnDelete();
            $table->string('title');
            $table->enum('type', ['video', 'pdf', 'text', 'link', 'audio', 'image'])->default('text');
            $table->string('file_path', 500)->nullable();
            $table->longText('content')->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_preview')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['module_id', 'order']);
        });

        Schema::create('material_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->unsignedInteger('last_position')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'material_id']);
        });

        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->unique(['student_id', 'material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('material_progress');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('course_modules');
    }
};
