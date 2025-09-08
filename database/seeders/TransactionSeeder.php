<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'client_id' => 1,
                'amount_spent' => 75.00,
                'points_earned' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 2,
                'amount_spent' => 110.00,
                'points_earned' => 22,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 3,
                'amount_spent' => 35.00,
                'points_earned' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
