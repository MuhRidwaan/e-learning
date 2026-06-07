<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseModuleController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MateriHubController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\QuizOptionController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Profile
    Route::get('/profile', [UserController::class, 'profile'])
        ->name('profile');

    Route::post('/profile/update', [UserController::class, 'updateProfile'])
        ->name('profile.update');


    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('syllabus', SyllabusController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

    // enrollment - quizcontroller
    Route::resource('quizzes', QuizController::class);

    Route::prefix('quizzes/{quiz}')
    ->name('quizzes.')
    ->group(function () {

        Route::get('/questions',
            [QuizQuestionController::class,'index'])
            ->name('questions.index');

        Route::get('/questions/create',
            [QuizQuestionController::class,'create'])
            ->name('questions.create');

        Route::post('/questions',
            [QuizQuestionController::class,'store'])
            ->name('questions.store');

        Route::get('/questions/{question}/edit',
            [QuizQuestionController::class,'edit'])
            ->name('questions.edit');

        Route::put('/questions/{question}',
            [QuizQuestionController::class,'update'])
            ->name('questions.update');

        Route::delete('/questions/{question}',
            [QuizQuestionController::class,'destroy'])
            ->name('questions.destroy');

        Route::get('/attempts',
            [QuizAttemptController::class, 'index'])
            ->name('attempts.index');

        Route::get('/take',
            [QuizAttemptController::class, 'take'])
            ->name('attempts.take');

        Route::post('/attempts',
            [QuizAttemptController::class, 'store'])
            ->name('attempts.store');

        Route::get('/attempts/{attempt}',
            [QuizAttemptController::class, 'show'])
            ->name('attempts.show');

        Route::get('/attempts/{attempt}/grade',
            [QuizAttemptController::class, 'gradeForm'])
            ->name('attempts.grade.form');

        Route::post('/attempts/{attempt}/grade',
            [QuizAttemptController::class, 'grade'])
            ->name('attempts.grade');
    });

    // enrollment - quiz options 
    Route::prefix('questions/{question}')
    ->name('questions.')
    ->group(function () {

        Route::get('/options',
            [QuizOptionController::class,'index'])
            ->name('options.index');

        Route::post('/options',
            [QuizOptionController::class,'store'])
            ->name('options.store');

        Route::put('/options/{option}',
            [QuizOptionController::class,'update'])
            ->name('options.update');

        Route::delete('/options/{option}',
            [QuizOptionController::class,'destroy'])
            ->name('options.destroy');
    });

    // Enrollment — manajemen pelajar & pengajar per kelas
    Route::prefix('courses/{course}/enrollments')->name('enrollments.')->group(function () {
        Route::get('/',                        [EnrollmentController::class, 'index'])->name('index');
        Route::post('/',                       [EnrollmentController::class, 'store'])->name('store');
        Route::put('/{enrollment}',            [EnrollmentController::class, 'update'])->name('update');
        Route::delete('/{enrollment}',         [EnrollmentController::class, 'destroy'])->name('destroy');
    });
    // Overview pelajar & pengajar (akademik)
    Route::get('/students',  [EnrollmentController::class, 'studentOverview'])->name('students.overview');
    Route::get('/teachers',  [EnrollmentController::class, 'teacherOverview'])->name('teachers.overview');

    // Hub materi — entry point dari sidebar
    Route::get('/materi', [MateriHubController::class, 'index'])->name('materi.hub');

    // Bookmark list for current student
    Route::get('/bookmarks', [MaterialController::class, 'bookmarks'])->name('bookmarks.index');

    // Forum global (langsung dari sidebar)
    Route::get('/forum', [ForumController::class, 'globalIndex'])->name('forum.global');

    // Forum routes per kelas
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

    // Materi & Modul routes per kelas
    Route::prefix('courses/{courseId}')->name('courses.')->group(function () {
        // Halaman utama materi (index modul)
        Route::get('/materials', [CourseModuleController::class, 'index'])->name('materials.index');

        // CRUD CourseModule
        Route::post('/modules',            [CourseModuleController::class, 'store'])->name('modules.store');
        Route::put('/modules/{module}',    [CourseModuleController::class, 'update'])->name('modules.update');
        Route::delete('/modules/{module}', [CourseModuleController::class, 'destroy'])->name('modules.destroy');

        // CRUD Material — create/store must come before {material} to avoid route conflict
        Route::get('/materials/create',          [MaterialController::class, 'create'])->name('materials.create');
        Route::post('/materials',                [MaterialController::class, 'store'])->name('materials.store');
        Route::get('/materials/{material}',      [MaterialController::class, 'show'])->name('materials.show');
        Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
        Route::put('/materials/{material}',      [MaterialController::class, 'update'])->name('materials.update');
        Route::delete('/materials/{material}',   [MaterialController::class, 'destroy'])->name('materials.destroy');

        // Progress & Bookmark (AJAX only)
        Route::post('/materials/{material}/progress', [MaterialController::class, 'progress'])->name('materials.progress');
        Route::post('/materials/{material}/bookmark', [MaterialController::class, 'bookmark'])->name('materials.bookmark');
        
        

    });
});