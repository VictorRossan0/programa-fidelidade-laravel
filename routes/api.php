<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\RedemptionController;

// Rota de teste rápido
Route::middleware(['token:001'])->get('/test', function () {
    return response()->json(['message' => 'Middleware funcionando!']);
});

// Rotas do programa de fidelidade
Route::middleware('token:001')->post('/clients', [ClientController::class, 'store']);
Route::middleware('token:002')->get('/clients/{id}', [ClientController::class, 'show']);
Route::middleware('token:003')->get('/clients', [ClientController::class, 'index']);
Route::middleware('token:004')->get('/clients/{id}/balance', [ClientController::class, 'balance']);
Route::middleware('token:006')->post('/points/earn', [PointController::class, 'earn']);
Route::middleware('token:005')->post('/redemptions', [RedemptionController::class, 'store']);
