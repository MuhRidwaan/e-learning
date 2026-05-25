<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. TAMPILAN ROLE: SUPER ADMIN
        if ($user->hasRole('super_admin')) {
            $stats = [
                'total_users'       => User::count(),
                'total_courses'     => Course::count(),
                'total_syllabus'    => 0,
                'total_assignments' => Assignment::count(),
            ];
            return view('dashboard', compact('stats'));
        }

        // 2. TAMPILAN ROLE: STAF AKADEMIK
        if ($user->hasRole('akademik')) {
            $stats = [
                'total_courses'  => Course::count(),
                'total_syllabus' => 0,
            ];
            return view('dashboard', compact('stats'));
        }

        // 3. TAMPILAN ROLE: PENGAJAR
        if ($user->hasRole('pengajar')) {
            $taughtCourses = Course::all();
            return view('dashboard', compact('taughtCourses'));
        }

        // 4. TAMPILAN ROLE: PELAJAR / SISWA (Default)
        $activeCourses = Course::limit(2)->get(); 
        $upcomingAssignments = Assignment::orderBy('due_date', 'asc')->limit(3)->get();

        // KUNCI PERBAIKAN: Mengubah $upcomingAssignments menjadi 'upcomingAssignments'
        return view('dashboard', compact('activeCourses', 'upcomingAssignments'));
    }
}