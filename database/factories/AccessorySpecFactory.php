<?php

namespace Database\Factories;

use App\Models\Accessory;
use App\Models\AccessorySpec;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccessorySpecFactory extends Factory
{
    protected $model = AccessorySpec::class;

    public function definition(): array
    {
        return [
            'dimension' => $this->faker->word(),
            'price' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'accessory_id' => Accessory::factory(),
        ];
    }
}
