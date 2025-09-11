<?php
/**
 * API Routes — Programa de Fidelidade
 *
 * Define os endpoints públicos da API com autenticação via Bearer Token
 * (middleware `token`). Cobrem cadastro e consulta de clientes, pontuação,
 * resgates e saldo, conforme requisitos do teste técnico.
 *
 * Endpoints:
 *  - POST /api/clients (001) — cadastro de cliente
 *  - GET  /api/clients/{id} (002) — buscar cliente
 *  - GET  /api/clients (003) — listar clientes
 *  - GET  /api/clients/{id}/balance (004) — saldo e resgates
 *  - POST /api/redemptions (005) — resgatar prêmio
 *  - POST /api/points/earn (006) — pontuar cliente
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\RedemptionController;

// Rotas do programa de fidelidade
Route::middleware('token:001')->post('/clients', [ClientController::class, 'store']);
Route::middleware('token:002')->get('/clients/{id}', [ClientController::class, 'show']);
Route::middleware('token:003')->get('/clients', [ClientController::class, 'index']);
Route::middleware('token:004')->get('/clients/{id}/balance', [ClientController::class, 'balance']);
Route::middleware('token:005')->post('/redemptions', [RedemptionController::class, 'store']);
Route::middleware('token:006')->post('/points/earn', [PointController::class, 'earn']);
