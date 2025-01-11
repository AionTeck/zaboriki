<?php

namespace Tests\Feature\Api\Gates;

use App\Models\Gate;
use App\Models\GateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetTypesTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        Gate::factory()
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        $response = $this->get('api/v1/gates/types');

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
}
