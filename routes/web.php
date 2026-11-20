<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\LessonVideoController;
use App\Http\Controllers\Student\CourseCatalogController;
use App\Http\Controllers\Student\LessonPlayerController;
use App\Http\Controllers\Student\VideoStreamController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('courses.index');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    Route::resource('courses', CourseController::class)->except('show');
    Route::resource('courses.lessons',LessonController::class)
        ->shallow()
        ->except('show');
    Route::patch('lessons/{lesson}/move/{direction}', [LessonController::class,'move'])
        ->whereIn('direction', ['up', 'down'])
        ->name('lessons.move');
    Route::post('lessons/{lesson}/video', [LessonVideoController::class,'store'])
    ->name('lessons.video.store');
    });

Route::middleware('auth')->group(function () {
    Route::get('/courses', [CourseCatalogController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseCatalogController::class, 'show'])->name('courses.show');
    Route::get('/lessons/{lesson}', [LessonPlayerController::class, 'show'])->name('lessons.show');
    Route::get('/lessons/{lesson}/video', VideoStreamController::class)->name('lessons.video');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
