<?php

namespace Database\Factories;

use App\Enum\Measurement;
use App\Models\Accessory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccessoryFactory extends Factory
{
    protected $model = Accessory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'measurement_type' => $this->faker->randomElement(Measurement::cases())
        ];
    }
}
