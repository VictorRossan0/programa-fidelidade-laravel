<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model que representa o resgate de prêmios pelos clientes.
class Redemption extends Model
{
	protected $fillable = ['client_id', 'reward_id'];

	// Relacionamento: resgate pertence a um cliente.
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	// Relacionamento: resgate pertence a um prêmio.
	public function reward()
	{
		return $this->belongsTo(Reward::class);
	}
}
