<?php

namespace Database\Factories;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

class RewardFactory extends Factory
{
    protected $model = Reward::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'points_required' => $this->faker->numberBetween(5, 20),
        ];
    }
}
