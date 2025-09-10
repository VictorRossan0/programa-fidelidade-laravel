<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\RedemptionController;

// Rota de teste rápido
// Route::middleware('token:001')->get('/test', function () {
//     return response()->json(['message' => 'Middleware Laravel 12 funcionando!']);
// });

// Rotas do programa de fidelidade
// Cada rota exige um token específico, conforme permissões da documentação
Route::middleware('token:001')->post('/clients', [ClientController::class, 'store']); // Cadastro de cliente
Route::middleware('token:002')->get('/clients/{id}', [ClientController::class, 'show']); // Consulta de cliente
Route::middleware('token:003')->get('/clients', [ClientController::class, 'index']); // Listagem de clientes
Route::middleware('token:004')->get('/clients/{id}/balance', [ClientController::class, 'balance']); // Consulta de saldo
Route::middleware('token:005')->post('/redemptions', [RedemptionController::class, 'store']); // Resgate de prêmio
Route::middleware('token:006')->post('/points/earn', [PointController::class, 'earn']); // Pontuar cliente
