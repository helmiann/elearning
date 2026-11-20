<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;

class CourseCatalogController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)
            ->withCount('lessons')
            ->latest()
            ->paginate(9);

        return view('student.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        Gate::authorize('view', $course);

        $lessons = $course->lessons;

        return view('student.courses.show', compact('course', 'lessons'));
    }
}
