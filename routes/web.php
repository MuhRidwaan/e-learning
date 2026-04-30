<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('courses', CourseController::class);

    // Forum routes
    Route::prefix('courses/{courseId}/forum')->name('forum.')->group(function () {
        Route::get('/',          [ForumController::class, 'index'])->name('index');
        Route::get('/create',    [ForumController::class, 'create'])->name('create');
        Route::post('/',         [ForumController::class, 'store'])->name('store');
        Route::get('/{threadId}', [ForumController::class, 'show'])->name('show');
        Route::delete('/{threadId}', [ForumController::class, 'destroy'])->name('destroy');
        Route::post('/{threadId}/pin',  [ForumController::class, 'togglePin'])->name('togglePin');
        Route::post('/{threadId}/lock', [ForumController::class, 'toggleLock'])->name('toggleLock');

        // Post/reply routes
        Route::post('/{threadId}/posts',                          [ForumController::class, 'storePost'])->name('storePost');
        Route::delete('/{threadId}/posts/{postId}',               [ForumController::class, 'destroyPost'])->name('destroyPost');
        Route::post('/{threadId}/posts/{postId}/solution',        [ForumController::class, 'markSolution'])->name('markSolution');
        Route::post('/{threadId}/posts/{postId}/unmark-solution', [ForumController::class, 'unmarkSolution'])->name('unmarkSolution');
    });
});
