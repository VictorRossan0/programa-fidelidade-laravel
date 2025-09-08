<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Point;
use App\Models\Redemption;
use App\Models\Transaction;


class Client extends Model
{
    use HasFactory;
	protected $fillable = ['name', 'email'];

	protected static function booted()
    {
        static::created(function ($client) {
            if ($client->points()->count() === 0) {
                \App\Models\Point::create(['client_id' => $client->id, 'amount' => 0]);
            }
        });
    }

	public function points()
	{
		return $this->hasMany(Point::class);
	}

	public function redemptions()
	{
		return $this->hasMany(Redemption::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
}
