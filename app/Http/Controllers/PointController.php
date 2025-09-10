<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPointsRequest;
use App\Models\Client;
use App\Models\Transaction;
use App\Jobs\SendPointsEmail;
use Illuminate\Routing\Controller;

// Controller responsável por pontuar clientes e registrar transações.
class PointController extends Controller
{
    // Adiciona pontos ao cliente conforme valor gasto e dispara e-mail.
    public function earn(AddPointsRequest $request)
    {
    $client = Client::findOrFail($request->input('client_id'));
    $points = floor($request->input('amount_spent') / 5);

        $client->points->increment('amount', $points);

        Transaction::create([
            'client_id'    => $client->id,
            'amount_spent' => $request->input('amount_spent'),
            'points_earned' => $points
        ]);

        dispatch(new SendPointsEmail($client, $points));

        return response()->json(['message' => 'Pontos adicionados com sucesso']);
    }
}
