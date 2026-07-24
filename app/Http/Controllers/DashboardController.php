<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Channel;
use App\Models\Userslikes;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class DashboardController extends Controller
{
    public function view(Request $request){
        // $channel = Channel::withCount('likes')->findOrFail($id);

        $user = $request->user();
        $liked_channels = $user->likes()->with('channel')->latest()->get()->pluck('channel')->filter()->values();
        $liked_channels_count = $liked_channels->count();

        $liked_tracks = $user->tracks_likes()->with('track')->latest()->get()->pluck('track')->filter()->values();
        $liked_tracks_count = $liked_tracks->count();

        // dd($user->likes());

        $channels = Userslikes::where($user); 

        $user = $request->User();

        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'liked_channels'=> $liked_channels,
            'liked_channels_count'=> $liked_channels_count,
            'liked_tracks'=> $liked_tracks,
            'liked_tracks_count'=> $liked_tracks_count, 
        ]);
    }

    // public function view($id){
    //     $channel = Channel::withCount('likes')->findOrFail($id);

    //     $playlist = Playlist::where('channel_id', $id)->first();

    //     $tracks = $playlist->tracks;

    //     return Inertia::render('Channel', [
    //         'channel' => $channel,
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //         'tracks'=> $tracks,
    //     ]);
    // }
}
