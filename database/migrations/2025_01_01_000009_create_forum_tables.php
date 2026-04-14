<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forum_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('forum_threads')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('forum_posts')->cascadeOnDelete();
            $table->text('content');
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_solution')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index('thread_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
        Schema::dropIfExists('forum_threads');
    }
};
