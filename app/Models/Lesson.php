<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Lesson extends Model
{
    protected $fillable = ['title', 'description'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function deleteVideoFile(): void
    {
        if ($this->video_path){
            Storage::disk('local')->delete($this->video_path);
        }
    }

    public function videoStatusLabel(): string
    {
        return match ($this->video_status){
            'uploading' => 'Sedang diunggah',
            'ready'=> 'Siap',
            'failed'=> 'Gagal',
            default => 'Belum ada video',
        };
    }
}
