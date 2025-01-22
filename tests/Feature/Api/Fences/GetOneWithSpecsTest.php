<?php

namespace Tests\Feature\Api\Fences;

use App\Models\Fence;
use App\Models\FenceCombination;
use App\Models\FenceSpec;
use App\Models\FenceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneWithSpecsTest extends TestCase
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

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'specs' => [
                    '*' => [
                        'spec_id',
                        'value',
                        'price'
                    ]
                ]
            ]
        ]);
    }
}
