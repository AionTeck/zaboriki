<?php

namespace Database\Factories;

use App\Enum\AccessoryableType;
use App\Models\Accessory;
use App\Models\Accessoryable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccessoryableFactory extends Factory
{
    protected $model = Accessoryable::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'accessory_id' => Accessory::factory(),
        ];
    }
}
