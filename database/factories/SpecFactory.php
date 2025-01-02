<?php

namespace Database\Factories;

use App\Models\Spec;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecFactory extends Factory
{
    protected $model = Spec::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
