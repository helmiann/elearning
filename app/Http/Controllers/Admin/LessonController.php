<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons;
        return view("admin.lessons.index", compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:225',
            'description' => 'nullable|string',
        ]);

        $lesson = new Lesson($data);
        $lesson->course_id = $course->id;
        $lesson->position = ($course->lessons()->max('position') ?? 0) +1;
        $lesson->save();

        return redirect()->route('admin.courses.lessons.index', $course)
        ->with('success', 'Lesson berhasil ditambahkan.');

    }

    public function edit(Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string|max:225',
            'description' => 'nullable|string',
        ]);

        $lesson->update($data);

        return redirect()->route('admin.courses.lessons.index', $lesson->course_id)
        ->with('success','Lesson berhasil diperbarui');
    }

    public function destroy(Lesson $lesson)
    {
        $courseId = $lesson->course_id;
        $lesson->delete();

        return redirect()->route('admin.courses.lessons.index', $courseId)
        ->with('success'. 'Lesson berhasil dihapus');
    }

    public function move(Lesson $lesson, string $direction)
    {
        $siblings = Lesson::where('course_id', $lesson->course_id);

        $neighbor = $direction === 'up'
            ? $siblings->where('position', '<',  $lesson->position)->orderByDesc('position')->first()
            : $siblings->where('position', '>',  $lesson->position)->orderBy('position')->first();

        if ($neighbor) {
            DB::transaction(function () use ($lesson, $neighbor){
                [$lesson->position, $neighbor->position] = [$neighbor->position, $lesson->position];
                $lesson->save();
                $neighbor->save();
            });
        }
        return back();

    }

}
