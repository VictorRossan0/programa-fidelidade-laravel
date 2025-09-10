<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Point;
use App\Models\Redemption;
use App\Models\Transaction;


// Model que representa o cliente do programa de fidelidade.
class Client extends Model
{
    use HasFactory;
	protected $fillable = ['name', 'email'];

	// Inicializa pontos ao criar cliente.
	protected static function booted()
    {
        static::created(function ($client) {
            if ($client->points()->count() === 0) {
                Point::create(['client_id' => $client->id, 'amount' => 0]);
            }
        });
    }

	// Relacionamento: cliente possui vários pontos.
	public function points()
	{
		return $this->hasMany(Point::class);
	}

	// Relacionamento: cliente possui vários resgates.
	public function redemptions()
	{
		return $this->hasMany(Redemption::class);
	}

	// Relacionamento: cliente possui várias transações.
	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
}
