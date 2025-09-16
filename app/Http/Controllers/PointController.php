<?php

/**
 * PointController
 *
 * Gerencia a pontuação (006): recebe valor gasto, calcula pontos (1 a cada R$5),
 * incrementa o saldo do cliente, registra transação e dispara e-mail.
 */

namespace App\Http\Controllers;

use App\Http\Requests\AddPointsRequest;
use App\Models\Client;
use App\Models\Transaction;
use App\Jobs\SendPointsEmail;
use Illuminate\Routing\Controller;

class PointController extends Controller
{
    /**
     * Adiciona pontos ao cliente (006) e dispara e-mail de confirmação.
     */
    public function earn(AddPointsRequest $request)
    {
        $client = Client::findOrFail($request->input('client_id'));
        $points = (int) floor($request->input('amount_spent') / 5);

        $point = $client->points()->firstOrCreate(['client_id' => $client->id], ['amount' => 0]);
        $point->increment('amount', $points);

        Transaction::create([
            'client_id'    => $client->id,
            'amount_spent' => $request->input('amount_spent'),
            'points_earned' => $points
        ]);

        $point->refresh();
        dispatch(new SendPointsEmail($client, $points));

        return response()->json(['message' => 'Pontos adicionados com sucesso']);
    }
}
