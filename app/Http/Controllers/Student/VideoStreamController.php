<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class VideoStreamController extends Controller
{
    public function __invoke(Lesson $lesson)
    {
        Gate::authorize('view', $lesson->course);

        $disk = Storage::disk('local');

        abort_unless(
            $lesson->video_status === 'ready'
                && $lesson->video_path
                && $disk->exists($lesson->video_path),
            404
        );

        return response()->file($disk->path($lesson->video_path), [
            'Content-Type' => $disk->mimeType($lesson->video_path),
        ])->setPrivate();
    }
}
