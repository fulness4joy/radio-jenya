<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class   HomeController extends Controller
{
    public function index(){
        $channels = Channel::all();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'channels'=> $channels,
        ]);
    }
}
