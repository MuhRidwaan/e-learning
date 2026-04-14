<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->string('guard_name', 125)->default('web');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->string('guard_name', 125)->default('web');
            $table->string('module', 100)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type')->default('App\\Models\\User');
            $table->primary(['role_id', 'model_id', 'model_type']);
            $table->index(['model_id', 'model_type']);
            $table->foreign('model_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->primary(['permission_id', 'role_id']);
        });

        Schema::create('user_permission', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type')->default('App\\Models\\User');
            $table->primary(['permission_id', 'model_id', 'model_type']);
            $table->foreign('model_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_permission');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
