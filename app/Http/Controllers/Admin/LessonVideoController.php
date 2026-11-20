<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonVideoController extends Controller
{
    public function store(Request $request, Lesson $lesson)
    {
        $request->validate([
            'video'=>['required', 'file', 'mimetypes:video/mp4, video/webm','max:204800'],
        ]);

        $lesson->deleteVideoFile();
        $lesson->forceFill([
            'video_path' => null,
            'video_original_name'=> null,
            'video_status' => 'uploading',
        ])->save();

        try {
            $file = $request->file('video');
            $path = $file->store('video/'. $lesson->course_id, 'local');
            $lesson->forceFill([
                'video_path' => $path,
                'video_original_name'=> $file->getClientOriginalName(),
                'video_status' => 'ready',
            ])->save();
        } catch(\Throwable $e){
            report($e);

            $lesson->forceFill(['video_status' => 'failed'])->save();

            return response()->json([
                'status' => 'failed',
                'message' => 'Video gagal disimpan',
            ], 500);
        }

        return response()->json([
            'status' => 'ready',
            'message' => 'Video berhasil diunggah',
            'name' => $lesson->video_original_name,
        ]);
    }
}
