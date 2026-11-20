<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::withCount('lessons')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
        $data['is_published'] = $request->boolean('is_published');

        Course::create($data);

        return redirect()->route('admin.courses.index')
        ->with('success','Course berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
        $data['is_published'] = $request->boolean('is_published');

        $course->update($data);

        return redirect()->route('admin.courses.index')
        ->with('success','Course berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(course $course)
    {
        foreach ($course->lessons as $lesson) {
            $lesson->deleteVideofile();
        }
        $course->delete();

        return redirect()->route('admin.courses.index')
        ->with('success','Course berhasil dihapus');
    }
}
