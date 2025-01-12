<?php

namespace Tests\Feature\Api\AutomaticForGates;

use App\Models\AutomaticForGate;
use App\Models\AutomaticForGateSpec;
use App\Models\GateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneTest extends TestCase
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

        $response = $this->get("/api/v1/automatic-for-gates/$automaticForGates->id");

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ]
        ]);
    }

    public function testError()
    {
        $gateType = GateType::factory()
            ->create();

        AutomaticForGate::factory()
            ->has(
                AutomaticForGateSpec::factory()
                    ->for($gateType),
                'specs'
            )
            ->create();

        $response = $this->get("/api/v1/automatic-for-gates/1000");

        $response->assertNotFound();
    }
}
