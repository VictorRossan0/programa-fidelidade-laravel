<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model que representa as transações de compra dos clientes.
class Transaction extends Model
{
	protected $fillable = ['client_id', 'amount_spent', 'points_earned'];

	// Relacionamento: transação pertence a um cliente.
	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
