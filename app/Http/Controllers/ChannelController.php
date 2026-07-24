<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\Channel;
use App\Models\Playlist;
use App\Models\User;
use App\Models\UsersLikes;
use App\Models\Tracks_likes;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use function Laravel\Prompts\alert;

class ChannelController extends Controller
{
    public function view($id){
        $channel = Channel::withCount('likes')->findOrFail($id);

        $playlist = Playlist::where('channel_id', $id)->first();

        $tracks = $playlist->tracks()->withCount("likes")->get();

        $time_start = $playlist->time_start;

        return Inertia::render('Channel', [
            'channel' => $channel,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'tracks' => $tracks,
            'time_start' => $time_start->timestamp,
        ]);
    }

    public function radio($id){
        
    }

    public function streamTrack(Request $request, $id)
    {
        $track = Track::findOrFail($id);
        $path = storage_path('app/public/' . $track->path);

        abort_unless(is_file($path), 404);

        $size = filesize($path);
        $start = 0;
        $end = $size - 1;
        $status = 200;

        if ($request->headers->has('Range')) {
            $status = 206;
            $range = $request->header('Range');

            if (preg_match('/bytes=(\d*)-(\d*)/', $range, $matches)) {
                if ($matches[1] !== '') {
                    $start = (int) $matches[1];
                }

                if ($matches[2] !== '') {
                    $end = min((int) $matches[2], $end);
                }
            }
        }

        $length = $end - $start + 1;

        return response()->stream(function () use ($path, $start, $length) {
            $handle = fopen($path, 'rb');
            fseek($handle, $start);

            $remaining = $length;

            while ($remaining > 0 && ! feof($handle)) {
                $chunkSize = min(8192, $remaining);
                echo fread($handle, $chunkSize);
                flush();

                $remaining -= $chunkSize;
            }

            fclose($handle);
        }, $status, [
            'Accept-Ranges' => 'bytes',
            'Content-Type' => 'audio/mpeg',
            'Content-Length' => $length,
            'Content-Range' => "bytes {$start}-{$end}/{$size}",
        ]);
    }

    public function get_all_time($tracks){
        $all_time = 0;

        foreach ($tracks as $track){
            $all_time += $track->time;
        }

        return $all_time;
    }

    public function likes(Request $request, $id){
        $like = UsersLikes::where('user_id', $request->user()->id)->
                            where('channel_id', $id)->
                            first();

        if($like){
            $like->delete();
        } else{
            UsersLikes::create(['user_id'=>$request->user()->id,
                                'channel_id'=>$id]);
        }

        return back();
    }

    public function tracks_likes(Request $request, $id){
        $like = Tracks_likes::where('user_id', $request->user()->id)->
                            where('track_id', $id)->
                            first();

        if($like){
            $like->delete();
        } else{
            Tracks_likes::create(['user_id'=>$request->user()->id,
                                'track_id'=>$id]);
        }

        return back();
    }

    // public function view($id){
    //     $channel = Channel::findOrFail($id);

    //     return Inertia::render('Channel', [
    //         'channel' => $channel
    //     ]);
    // }

    // public function tracks(){
    //     $tracks = Track::all();

    //     return Inertia::render('Channel', [
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //         'tracks'=> $tracks,
    //     ]);
    // }
}
