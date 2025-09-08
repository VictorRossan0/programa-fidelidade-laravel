<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardSeeder extends Seeder
{
    public function run()
    {
        DB::table('rewards')->insert([
            [
                'id' => 1,
                'name' => 'Suco de Laranja',
                'points_required' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => '10% de desconto',
                'points_required' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Almoço Especial',
                'points_required' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
