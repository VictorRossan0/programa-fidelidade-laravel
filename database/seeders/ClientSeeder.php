<?php
/**
 * ClientSeeder
 *
 * Insere alguns clientes de exemplo para desenvolvimento e testes.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    public function run()
    {
        DB::table('clients')->insert([
            [
                'id' => 1,
                'name' => 'João Silva',
                'email' => 'joao.silva@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Maria Souza',
                'email' => 'maria.souza@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Carlos Lima',
                'email' => 'carlos.lima@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
