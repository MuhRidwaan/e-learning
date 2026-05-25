<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    private function getInstructorCourses()
    {
        // Super admin lihat semua course
        if (Auth::user()->hasRole('super_admin')) {
            return Course::pluck('id');
        }

        return Course::where('instructor_id', Auth::id())
            ->orWhereHas('instructors', fn($q) => $q->where('user_id', Auth::id()))
            ->pluck('id');
    }

    public function index()
    {
        if (!Auth::user()->hasPermission('assignments.view')) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->hasRole('super_admin')) {
            $assignments = Assignment::with('course')->latest()->get();
        } else {
            $courseIds = $this->getInstructorCourses();
            $assignments = Assignment::with('course')
                ->whereIn('course_id', $courseIds)
                ->where('created_by', Auth::id())
                ->latest()
                ->get();
        }

        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('assignments.create')) {
            abort(403, 'Unauthorized action.');
        }

        $courseIds = $this->getInstructorCourses();

        $courses = Course::whereIn('id', $courseIds)->get();
        return view('assignments.form', compact('courses'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('assignments.create')) {
            abort(403, 'Unauthorized action.');
        }

        $courseIds = $this->getInstructorCourses();

        $validator = validator($request->all(), [
            'course_id'   => ['required', 'exists:courses,id', function ($attr, $val, $fail) use ($courseIds) {
                if (!$courseIds->contains($val)) $fail('Course tidak valid.');
            }],
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'due_date'    => 'required|date|after:now',
            'max_score'   => 'required|integer|min:1|max:100',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = array_merge($validator->validated(), ['created_by' => Auth::id()]);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('assignments/files', 'public');
        }

        Assignment::create($data);

        return response()->json([
            'message'  => 'Tugas berhasil dibuat.',
            'redirect' => route('assignments.index'),
        ]);
    }

    public function show(Assignment $assignment)
    {
        if (!Auth::user()->hasPermission('assignments.view')) {
            abort(403, 'Unauthorized action.');
        }

        $this->authorizeAssignment($assignment);

        $assignment->load(['course', 'creator']);
        $assignment->loadCount('submissions');

        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        if (!Auth::user()->hasPermission('assignments.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $this->authorizeAssignment($assignment);

        $courseIds = $this->getInstructorCourses();
        $courses   = Course::whereIn('id', $courseIds)->get();

        return view('assignments.form', compact('assignment', 'courses'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        if (!Auth::user()->hasPermission('assignments.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $this->authorizeAssignment($assignment);

        $courseIds = $this->getInstructorCourses();

        $validator = validator($request->all(), [
            'course_id'   => ['required', 'exists:courses,id', function ($attr, $val, $fail) use ($courseIds) {
                if (!$courseIds->contains($val)) $fail('Course tidak valid.');
            }],
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'due_date'    => 'required|date|after:now',
            'max_score'   => 'required|integer|min:1|max:100',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('file')) {
            if ($assignment->file && Storage::disk('public')->exists($assignment->file)) {
                Storage::disk('public')->delete($assignment->file);
            }
            $data['file'] = $request->file('file')->store('assignments/files', 'public');
        } else {
            unset($data['file']);
        }

        $assignment->update($data);

        return response()->json([
            'message'  => 'Tugas berhasil diperbarui.',
            'redirect' => route('assignments.show', $assignment->id),
        ]);
    }

    public function destroy(Assignment $assignment)
    {
        if (!Auth::user()->hasPermission('assignments.delete')) {
            abort(403, 'Unauthorized action.');
        }

        $this->authorizeAssignment($assignment);

        if ($assignment->file && Storage::disk('public')->exists($assignment->file)) {
            Storage::disk('public')->delete($assignment->file);
        }

        $assignment->delete();

        return response()->json(['message' => 'Tugas berhasil dihapus.']);
    }

    // Pastikan pengajar hanya bisa akses tugasnya sendiri
    private function authorizeAssignment(Assignment $assignment)
    {
        if (Auth::user()->hasRole('super_admin')) {
            return; // super admin boleh akses semua
        }

        if ($assignment->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }
    }
}
