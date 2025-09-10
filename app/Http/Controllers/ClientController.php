<?php

// Controller responsável pelo cadastro, consulta e listagem de clientes.
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Point;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    // Cadastra um novo cliente e inicializa seus pontos.
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        Point::create(['client_id' => $client->id, 'amount' => 0]);

        return response()->json($client, 201);
    }


    // Retorna os dados de um cliente específico, incluindo pontos e resgates.
    public function show($id)
    {
        return Client::with('points', 'redemptions.reward')->findOrFail($id);
    }

    // Lista todos os clientes cadastrados.
    public function index()
    {
        return Client::all();
    }

    // Consulta o saldo de pontos e os resgates do cliente.
    public function balance($id)
    {
        $client = Client::with('points', 'redemptions.reward')->findOrFail($id);
        return response()->json([
            'saldo' => $client->points->amount,
            'resgates' => $client->redemptions
        ]);
    }
}
