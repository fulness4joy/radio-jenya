<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\DashboardController;
use App\Models\Channel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [HomeController::class, "index"])->name("home");
Route::get('/channel/{id}', [ChannelController::class, "view"])->name("view");
Route::post('/channel/like/{id}', [ChannelController::class, "likes"])->middleware("auth")->name("likes");
Route::get('/channel/radio/{id}', [ChannelController::class, "radio"])->name("radio");

Route::get('/radio/{id}', [ChannelController::class, "view"])->name("view_radio");

Route::get('/track/{id}/stream', [ChannelController::class, "streamTrack"])->name("track.stream");
Route::post('/track/like/{id}', [ChannelController::class, "tracks_likes"])->middleware("auth")->name("tracks_likes");

Route::get('/dashboard', [DashboardController::class, "view"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
