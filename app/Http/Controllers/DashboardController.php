<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\User;
use App\Models\Syllabus;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Routing pimpinan
        if ($user->hasRole('pimpinan')) {
            return redirect()->route('dashboard.pimpinan');
        }

        // 2. Inisialisasi variabel
        $stats = [
            'total_users' => 0,
            'total_courses' => 0,
            'total_syllabus' => 0,
            'teacher_materials_count' => 0,
            'pending_grading_count' => 0
        ];
        
        $courses = collect();
        $taughtCourses = collect();
        $activeCourses = collect();
        $upcomingAssignments = collect();

        // 3. Logic untuk Super Admin & Akademik
        if ($user->hasRole('super_admin') || $user->hasRole('akademik')) {
        $stats['total_users'] = User::count();
        $stats['total_courses'] = Course::count();
        $stats['total_syllabus'] = Syllabus::count();
        }

        // 4. Logic untuk Pengajar
        if ($user->hasRole('pengajar')) {
            $taughtCourses = $user->taughtCourses()->get();
            $courseIds = $taughtCourses->pluck('id')->all();
            
            $stats['teacher_materials_count'] = Material::whereHas('module', function ($q) use ($courseIds) {
                $q->whereIn('course_id', $courseIds);
            })->count();
            $stats['pending_grading_count'] = AssignmentSubmission::where('status', 'pending')
                ->whereHas('assignment', function ($q) use ($courseIds) {
                    $q->whereIn('course_id', $courseIds);
                })->count();
        }

        // 5. Logic untuk Pelajar
        if ($user->hasRole('pelajar')) {
            $activeCourses = $user->enrolledCourses()->where('enrollments.status', 'active')->get();
            $upcomingAssignments = Assignment::with('course')
                ->where('due_date', '>=', now())
                ->whereHas('course.enrollments', function ($q) use ($user) {
                    $q->where('student_id', $user->id)->where('status', 'active');
                })
                ->orderBy('due_date', 'asc')
                ->take(5)
                ->get();
        }

        // 6. Return ke view 'dashboard'
        return view('dashboard', compact(
            'stats', 
            'courses', 
            'taughtCourses', 
            'activeCourses', 
            'upcomingAssignments'
        ));
    }
}