<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class LandingPageController extends Controller
{
    public function index()
    {
        $courses = Course::oldest()->take(3)->get();
        return view('landing.index', compact('courses'));
    }

    public function catalog()
    {
        $courses = Course::latest()->paginate(9);
        return view('landing.catalog', compact('courses'));
    }

    public function preview($id)
    {
        $course = Course::with(['modules', 'instructor'])->findOrFail($id);
        return view('landing.preview', compact('course'));
    }
}
