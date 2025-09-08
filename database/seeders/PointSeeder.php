<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointSeeder extends Seeder
{
    public function run()
    {
        DB::table('points')->insert([
            [
                'client_id' => 1,
                'amount' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 2,
                'amount' => 22,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 3,
                'amount' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
