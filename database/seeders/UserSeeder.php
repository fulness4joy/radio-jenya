<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        Log::info('UserSeeder env', [
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
        ]);

        Log::info('Users before insert', [
            'count' => DB::table('users')->count(),
        ]);

        DB::table('users')->insert([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);

        Log::info('Users after insert', [
            'count' => DB::table('users')->count(),
        ]);
    }
}
