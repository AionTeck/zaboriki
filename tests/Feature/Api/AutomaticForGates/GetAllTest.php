<?php

namespace Tests\Feature\Api\AutomaticForGates;

use App\Models\AutomaticForGate;
use App\Models\AutomaticForGateSpec;
use App\Models\GateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $gateType = GateType::factory()
            ->create();

        $automaticForGates = AutomaticForGate::factory()
            ->has(
                AutomaticForGateSpec::factory()
                    ->for($gateType),
                'specs'
            )
            ->create();

        $queryParams = http_build_query([
            'gateTypeId' => $gateType->id
        ]);

        $response = $this->get("/api/v1/automatic-for-gates?$queryParams");

        $response->assertSuccessful();

        $response->assertJsonCount($automaticForGates->count(), 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]
        ]);
    }
}
