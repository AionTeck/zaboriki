<?php

namespace Database\Factories;

use App\Models\AutomaticForGates;
use App\Models\AutomaticForGatesSpec;
use App\Models\GateType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AutomaticForGatesSpecFactory extends Factory
{
    protected $model = AutomaticForGatesSpec::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'automatic_for_gates_id' => AutomaticForGates::factory(),
            'gate_type_id' => GateType::factory(),
        ];
    }
}
