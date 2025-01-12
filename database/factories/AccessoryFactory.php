<?php

namespace Database\Factories;

use App\Models\Accessory;
use App\Models\Measurement;
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

            'measurement_id' => Measurement::factory(),
        ];
    }
}
