<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;

class LessonPlayerController extends Controller
{
    public function show(Lesson $lesson)
    {
        $course = $lesson->course;

        Gate::authorize('view', $course);

        $lessons = $course->lessons;

        return view('student.lessons.show', compact('lesson', 'course', 'lessons'));
    }
}
