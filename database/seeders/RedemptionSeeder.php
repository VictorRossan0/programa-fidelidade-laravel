<?php
/**
 * RedemptionSeeder
 *
 * Registra resgates de prêmios de exemplo.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RedemptionSeeder extends Seeder
{
    public function run()
    {
        DB::table('redemptions')->insert([
            [
                'client_id' => 1,
                'reward_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 2,
                'reward_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
