<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Point;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        Point::create(['client_id' => $client->id, 'amount' => 0]);

        return response()->json($client, 201);
    }


    public function show($id)
    {
        return Client::with('points', 'redemptions.reward')->findOrFail($id);
    }

    public function index()
    {
        return Client::all();
    }

    public function balance($id)
    {
        $client = Client::with('points', 'redemptions.reward')->findOrFail($id);
        return response()->json([
            'saldo' => $client->points->amount,
            'resgates' => $client->redemptions
        ]);
    }
}
