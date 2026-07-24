<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => env("ADMIN_NAME"),
            'email' => env("ADMIN_EMAIL"),
            'password' => Hash::make(env("ADMIN_PASSWORD")),
        ]);
    }
}
