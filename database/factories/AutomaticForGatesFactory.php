<?php

namespace Database\Factories;

use App\Models\AutomaticForGates;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AutomaticForGatesFactory extends Factory
{
    protected $model = AutomaticForGates::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
