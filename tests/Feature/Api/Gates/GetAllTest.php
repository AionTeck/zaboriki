<?php

namespace Tests\Feature\Api\Gates;

use App\Models\Gate;
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

        $response = $this->get("api/v1/gates");

        $response->assertSuccessful();

        $response->assertJsonCount($gates->count(), 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]
        ]);
    }

    public function testWithFilters()
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
            'typeId' => $type->id
        ]);

        $response = $this->get("api/v1/gates?$queryParams");

        $response->assertSuccessful();

        $response->assertJsonCount($gates->count(), 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]
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
            'typeId' => 'someTypeId'
        ]);

        $response = $this->get("api/v1/gates?$queryParams");

        $response->assertJsonStructure([
            'error_message',
            'error_code',
            'error_context'
        ]);

        $response->assertStatus(422);
    }
}
