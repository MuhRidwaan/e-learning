<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('student_id')->constrained('users');
            $table->string('certificate_no', 100)->unique();
            $table->string('file_path', 500)->nullable();
            $table->timestamp('issued_at')->nullable()->useCurrent();
            $table->timestamps();
            $table->unique(['course_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
