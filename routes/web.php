<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\RatingController;
use App\Models\Feedback;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
    ]);
})->name('welcome');


Route::middleware('auth')->group(function () {
    Route::prefix('project')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('project.create');
        Route::get('/{slug}', [ProjectController::class, 'show'])->name('project.show');
        Route::get('/project/{project:slug}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('/project/{project:slug}', [ProjectController::class, 'update'])->name('project.update');        
        Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
    });
    Route::get('/dashboard', function(){
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/profile/{nickname}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/user-profile', UserProfileController::class)
        ->only(['store', 'show', 'update']);
    Route::post('/project/{id}/rate', [FeedbackController::class, 'store'])
        ->name('project.rate');
    Route::put('/project/{project}/rate', [FeedbackController::class, 'update'])
        ->name('project.rate.update');
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
