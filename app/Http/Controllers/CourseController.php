<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('courses.view')) {
            abort(403, 'Unauthorized action.');
        }

        $query = Course::query()->with('instructor');

        // Pengajar: lihat kelas yang diajar
        if (Auth::user()->hasRole('pengajar')) {
            $query->where('instructor_id', Auth::id());
        }

        // Pelajar: hanya kelas yang sudah dipublish
        if (Auth::user()->hasRole('pelajar')) {
            $query->where('status', 'published');
        }

        $courses = $query
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        abort(501, 'Not implemented.');
    }

    public function store(Request $request)
    {
        abort(501, 'Not implemented.');
    }

    public function show(string $id)
    {
        if (!Auth::user()->hasPermission('courses.view')) {
            abort(403, 'Unauthorized action.');
        }

        $course = Course::with('instructor')->findOrFail($id);

        // Pelajar tidak boleh membuka kelas draft/archived
        if (Auth::user()->hasRole('pelajar') && $course->status !== 'published') {
            abort(403, 'Kelas belum dipublish.');
        }

        // Pengajar hanya boleh membuka kelas miliknya
        if (Auth::user()->hasRole('pengajar') && $course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('courses.show', compact('course'));
    }

    public function edit(string $id)
    {
        abort(501, 'Not implemented.');
    }

    public function update(Request $request, string $id)
    {
        abort(501, 'Not implemented.');
    }

    public function destroy(string $id)
    {
        abort(501, 'Not implemented.');
    }
}
