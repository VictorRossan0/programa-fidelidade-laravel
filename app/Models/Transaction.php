<?php

/**
 * Model Transaction
 *
 * Histórico de compras: valor gasto e pontos gerados.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['client_id', 'amount_spent', 'points_earned'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
