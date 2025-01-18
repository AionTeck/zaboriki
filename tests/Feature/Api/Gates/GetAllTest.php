<?php

namespace Tests\Feature\Api\Gates;

use App\Models\Gate;
use App\Models\GateSpec;
use App\Models\GateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $gates = Gate::factory(10)
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        $response = $this->get('api/v1/gates');

        $response->assertSuccessful();

        $response->assertJsonCount($gates->count(), 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }

    public function testWithFilters()
    {
        $gate = Gate::factory()
            ->for(
                $type = GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        Gate::factory(10)
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        $gateSpec = GateSpec::factory()
            ->for($gate, 'gate')
            ->create([
                'height' => 2000,
                'width' => 4000,
            ]);

        $queryParams = http_build_query([
            'typeId' => $type->id,
            'height' => $gateSpec->height / 1000,
            'width' => $gateSpec->width / 1000,
        ]);

        $response = $this->get("api/v1/gates?$queryParams");

        $response->assertSuccessful();

        $response->assertJsonCount(1, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }

    public function testWithFiltersError()
    {
        $gates = Gate::factory(10)
            ->for(
                $type = GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        Gate::factory(10)
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        $queryParams = http_build_query([
            'typeId' => 'someTypeId',
        ]);

        $response = $this->get("api/v1/gates?$queryParams");

        $response->assertJsonStructure([
            'error_message',
            'error_code',
            'error_context',
        ]);

        $response->assertStatus(422);
    }
}
