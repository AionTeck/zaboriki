<?php

namespace Database\Factories;

use App\Models\FenceSpec;
use Illuminate\Database\Eloquent\Factories\Factory;

class FenceSpecFactory extends Factory
{
    protected $model = FenceSpec::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->word(),
            'price' => $this->faker->randomNumber(),
        ];
    }
}
