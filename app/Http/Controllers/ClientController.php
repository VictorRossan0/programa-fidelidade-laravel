<?php

/**
 * ClientController
 *
 * Responsável por cadastro (001), consulta (002), listagem (003) e saldo (004)
 * de clientes do programa de fidelidade.
 */

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Cadastra um novo cliente (001) e inicializa seus pontos via evento do Model.
     */
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        // A criação do registro de pontos é realizada no evento booted() do Model Client

        return response()->json($client, 201);
    }


    /**
     * Retorna os dados de um cliente (002), incluindo pontos e resgates.
     */
    public function show($id)
    {
        return Client::with('points', 'redemptions.reward')->findOrFail($id);
    }

    /**
     * Lista todos os clientes (003).
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Consulta o saldo de pontos e resgates do cliente (004).
     */
    public function balance($id)
    {
        $client = Client::with('points', 'redemptions.reward')->findOrFail($id);
        return response()->json([
            'saldo' => $client->points->sum('amount'),
            'resgates' => $client->redemptions
        ]);
    }
}
