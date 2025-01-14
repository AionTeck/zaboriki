<?php

namespace Tests\Feature;

use App\Enum\SpecType;
use App\Models\Fence;
use App\Models\FenceCombination;
use App\Models\FenceSpec;
use App\Models\FenceType;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneCombinationsTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $fence = Fence::factory()
            ->for(
                FenceType::factory()
                    ->create([
                        'name' => 'Профлист',
                    ]),
                'type'
            )
            ->create();

        FenceSpec::factory(2)
            ->for($fence)
            ->sequence(
                [
                    'value' => 'С-20 2000х1150мм, толщ. 0,35 мм, цинк',
                    'price' => 1100,
                ],
                [
                    'value' => 'С-8 2000х1200мм, толщ. 0,35 мм, цинк',
                    'price' => 1130
                ]
            )
            ->create();

        $response = $this->get('/api/v1/fences/' . $fence->id . '/specs');

        var_dump($response->json());
        exit();
    }
}
