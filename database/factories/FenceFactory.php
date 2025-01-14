<?php

namespace Database\Factories;

use App\Enum\Measurement;
use App\Models\Fence;
use App\Models\FenceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class FenceFactory extends Factory
{
    protected $model = Fence::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'measurement_type' => $this->faker->randomElement(Measurement::cases()),
            'type_id' => FenceType::factory(),
        ];
    }
}
