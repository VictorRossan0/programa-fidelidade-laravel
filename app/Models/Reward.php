<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Redemption;

// Model que representa os prêmios disponíveis para resgate.
class Reward extends Model
{
    use HasFactory;
	protected $fillable = ['name', 'points_required'];

	// Relacionamento: prêmio pode ter vários resgates.
	public function redemptions()
	{
		return $this->hasMany(Redemption::class);
	}
}
