<?php
/**
 * Model Redemption
 *
 * Registra o resgate de prêmios pelos clientes.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
	protected $fillable = ['client_id', 'reward_id'];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function reward()
	{
		return $this->belongsTo(Reward::class);
	}
}
