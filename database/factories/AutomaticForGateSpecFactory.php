<?php

namespace Database\Factories;

use App\Models\AutomaticForGate;
use App\Models\AutomaticForGateSpec;
use App\Models\GateType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AutomaticForGateSpecFactory extends Factory
{
    protected $model = AutomaticForGateSpec::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'automatic_for_gate_id' => AutomaticForGate::factory(),
            'gate_type_id' => GateType::factory(),
        ];
    }
}
