<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('playlists')->updateOrInsert(
            ['name' => 'Rok', 'channel_id' => 1],
            [
                'description' => 'cool',
                'image' => '',
                'time_start' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
