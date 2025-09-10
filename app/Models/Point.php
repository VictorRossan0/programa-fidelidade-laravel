<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model que representa os pontos do cliente.
class Point extends Model
{
	protected $fillable = ['client_id', 'amount'];

	// Relacionamento: ponto pertence a um cliente.
	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
