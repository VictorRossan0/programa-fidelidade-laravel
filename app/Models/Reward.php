<?php

/**
 * Model Reward
 *
 * Prêmios disponíveis e pontuação exigida.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Redemption;

class Reward extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'points_required'];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }
}
