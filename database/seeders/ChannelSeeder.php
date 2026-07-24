<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {
        DB::table('channels')->insert([
            [
                'name' => "Rok",
                'description' => "cool",
                'image' => ""
            ],
            [
                'name' => "ert",
                'description' => "cool",
                'image' => "01KHC2Y8WWSSTBBZ2FXWXMJVGP.png"
            ]
        ]);
    }
}
