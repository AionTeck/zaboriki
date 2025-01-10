<?php

namespace Database\Factories;

use App\Models\Gate;
use App\Models\GateSpec;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GateSpecFactory extends Factory
{
    protected $model = GateSpec::class;

    public function definition(): array
    {
        return [
            'width' => $this->faker->randomNumber(),
            'height' => $this->faker->randomNumber(),
            'price' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'gate_id' => Gate::factory(),
        ];
    }
}
