<?php

namespace Tests\Feature\Api\Gates;

use App\Models\Fence;
use App\Models\FenceCombination;
use App\Models\FenceSpec;
use App\Models\FenceType;
use App\Models\Gate;
use App\Models\GateSpec;
use App\Models\GateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneWithSpecsTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $gate = Gate::factory()
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        GateSpec::factory()
            ->for(
                $gate,
                'gate'
            )
            ->create();

        $response = $this->get('/api/v1/gates/' . $gate->id . '/specs');

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'specs' => [
                    '*' => [
                        'spec_id',
                        'height',
                        'width',
                        'price',
                    ]
                ]
            ]
        ]);
    }

    public function testError()
    {
        $gate = Gate::factory()
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        GateSpec::factory()
            ->for(
                $gate,
                'gate'
            )
            ->create();

        $response = $this->get('/api/v1/gates/' . 1000 . '/specs');

        $response->assertNotFound();
    }
}
