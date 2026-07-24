<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tracks = [
            [
                'name' => 'Morning Static',
                'description' => 'First playlist track',
                'image' => '',
                'path' => '01KKM06WQFDRGB84HA599H1D2E.mp3',
                'status' => 'show',
                'time' => 228,
            ],
            [
                'name' => 'Night Drive',
                'description' => 'Second playlist track',
                'image' => '',
                'path' => '01KPDQNRAV3R8H8QQPK88GHS1X.mp3',
                'status' => 'show',
                'time' => 153,
            ],
        ];

        foreach ($tracks as $track) {
            DB::table('tracks')->updateOrInsert(
                ['path' => $track['path']],
                [...$track, 'updated_at' => now(), 'created_at' => now()],
            );
        }

        $playlistId = DB::table('playlists')
            ->where('name', 'Rok')
            ->where('channel_id', 1)
            ->value('id');

        if (! $playlistId) {
            return;
        }

        $trackIds = DB::table('tracks')
            ->whereIn('path', array_column($tracks, 'path'))
            ->pluck('id');

        DB::table('tracks_to__playlists')
            ->where('playlist_id', $playlistId)
            ->delete();

        DB::table('tracks_to__playlists')->insert(
            $trackIds->map(fn ($trackId) => [
                'track_id' => $trackId,
                'playlist_id' => $playlistId,
                'created_at' => now(),
                'updated_at' => now(),
            ])->all(),
        );
    }
}
