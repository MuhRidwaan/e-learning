<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Material;
use App\Models\MaterialProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Show the form for creating a new material.
     */
    public function create($courseId)
    {
        if (!Auth::user()->hasPermission('materials.create')) {
            abort(403, 'Unauthorized action.');
        }

        $course  = Course::findOrFail($courseId);
        $modules = $course->modules()->get();

        return view('materials.create', compact('course', 'modules'));
    }

    /**
     * Store a newly created material.
     */
    public function store(Request $request, $courseId)
    {
        if (!Auth::user()->hasPermission('materials.create')) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $validator = validator($request->all(), [
            'title'            => 'required|string|max:255',
            'module_id'        => 'required|exists:course_modules,id',
            'type'             => 'required|in:video,pdf,text,link,audio,image',
            'order'            => 'required|integer|min:0',
            'is_preview'       => 'boolean',
            'duration_minutes' => 'nullable|integer|min:0',
            'content'          => 'nullable|string',
            'file_path'        => 'required_if:type,pdf,image,audio|nullable|file|mimes:pdf,jpg,jpeg,png,webp,mp3,wav,mp4,webm|max:102400',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $type     = $request->type;
            $filePath = $request->file('file_path')->store("materials/{$type}", 'public');
        }

        Material::create([
            'module_id'        => $request->module_id,
            'title'            => $request->title,
            'type'             => $request->type,
            'file_path'        => $filePath,
            'content'          => $request->content,
            'duration_minutes' => $request->duration_minutes,
            'order'            => $request->order,
            'is_preview'       => $request->boolean('is_preview'),
        ]);

        return response()->json([
            'message'  => 'Materi berhasil ditambahkan.',
            'redirect' => route('courses.materials.index', $courseId),
        ]);
    }

    /**
     * Display the specified material.
     */
    public function show($courseId, Material $material)
    {
        if (!Auth::user()->hasPermission('materials.view')) {
            abort(403, 'Unauthorized action.');
        }

        $course = Course::findOrFail($courseId);

        $isEnrolled = DB::table('enrollments')
            ->where('course_id', $courseId)
            ->where('student_id', Auth::id())
            ->where('status', 'active')
            ->exists();

        $isPengajar = Auth::user()->hasPermission('materials.create');

        // Block non-enrolled students from non-preview materials
        if (!$isPengajar && !$isEnrolled && !$material->is_preview) {
            abort(403, 'Anda belum terdaftar di kelas ini.');
        }

        $progress     = $material->progressFor(Auth::id());
        $isBookmarked = $material->isBookmarkedBy(Auth::id());

        return view('materials.show', compact(
            'course',
            'material',
            'isEnrolled',
            'isPengajar',
            'progress',
            'isBookmarked'
        ));
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit($courseId, Material $material)
    {
        if (!Auth::user()->hasPermission('materials.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $course  = Course::findOrFail($courseId);
        $modules = $course->modules()->get();

        return view('materials.edit', compact('course', 'material', 'modules'));
    }

    /**
     * Update the specified material.
     */
    public function update(Request $request, $courseId, Material $material)
    {
        if (!Auth::user()->hasPermission('materials.edit')) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        // file_path required only if type needs file AND no existing file
        $fileRequired = in_array($request->type, ['pdf', 'image', 'audio']) && !$material->file_path;

        $validator = validator($request->all(), [
            'title'            => 'required|string|max:255',
            'module_id'        => 'required|exists:course_modules,id',
            'type'             => 'required|in:video,pdf,text,link,audio,image',
            'order'            => 'required|integer|min:0',
            'is_preview'       => 'boolean',
            'duration_minutes' => 'nullable|integer|min:0',
            'content'          => 'nullable|string',
            'file_path'        => ($fileRequired ? 'required' : 'nullable') . '|file|mimes:pdf,jpg,jpeg,png,webp,mp3,wav,mp4,webm|max:102400',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $filePath = $material->file_path;

        if ($request->hasFile('file_path')) {
            // Delete old file
            if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
                try {
                    Storage::disk('public')->delete($material->file_path);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete old material file: ' . $e->getMessage());
                }
            }

            $type     = $request->type;
            $filePath = $request->file('file_path')->store("materials/{$type}", 'public');
        }

        $material->update([
            'module_id'        => $request->module_id,
            'title'            => $request->title,
            'type'             => $request->type,
            'file_path'        => $filePath,
            'content'          => $request->content,
            'duration_minutes' => $request->duration_minutes,
            'order'            => $request->order,
            'is_preview'       => $request->boolean('is_preview'),
        ]);

        return response()->json([
            'message'  => 'Materi berhasil diperbarui.',
            'redirect' => route('courses.materials.index', $courseId),
        ]);
    }

    /**
     * Soft delete the specified material and remove its file.
     */
    public function destroy($courseId, Material $material)
    {
        if (!Auth::user()->hasPermission('materials.delete')) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        // Delete file from storage
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return response()->json(['message' => 'Materi berhasil dihapus.']);
    }

    /**
     * Update or create progress record for the current student.
     */
    public function progress(Request $request, $courseId, Material $material)
    {
        $validator = validator($request->all(), [
            'is_completed'  => 'boolean',
            'last_position' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $isCompleted = $request->boolean('is_completed', false);
        $data        = [
            'is_completed'  => $isCompleted,
            'last_position' => $request->input('last_position', 0),
        ];

        if ($isCompleted) {
            $data['completed_at'] = now();
        }

        $progress = MaterialProgress::updateOrCreate(
            [
                'student_id'  => Auth::id(),
                'material_id' => $material->id,
            ],
            $data
        );

        return response()->json([
            'message'       => $isCompleted ? 'Materi ditandai selesai.' : 'Progress disimpan.',
            'is_completed'  => $progress->is_completed,
            'last_position' => $progress->last_position,
        ]);
    }

    /**
     * Toggle bookmark for the current student.
     */
    public function bookmark(Request $request, $courseId, Material $material)
    {
        $existing = Bookmark::where('student_id', Auth::id())
            ->where('material_id', $material->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'message'      => 'Bookmark dihapus.',
                'is_bookmarked' => false,
            ]);
        }

        Bookmark::create([
            'student_id'  => Auth::id(),
            'material_id' => $material->id,
            'note'        => $request->input('note'),
        ]);

        return response()->json([
            'message'      => 'Materi berhasil di-bookmark.',
            'is_bookmarked' => true,
        ]);
    }
}
