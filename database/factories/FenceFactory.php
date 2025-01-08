<?php

namespace Database\Factories;

use App\Models\Fence;
use App\Models\FenceType;
use App\Models\Measurement;
use Illuminate\Database\Eloquent\Factories\Factory;

class FenceFactory extends Factory
{
    protected $model = Fence::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'measurement_id' => Measurement::factory(),
            'type_id' => FenceType::factory(),
        ];
    }
}
