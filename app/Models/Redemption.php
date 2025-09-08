<?php

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
