<?php

namespace Tests\Feature\Api\Fences;

use App\Models\Fence;
use App\Models\FenceSpec;
use App\Models\FenceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        Fence::factory()
            ->for(
                FenceType::factory()
                    ->create([
                        'name' => 'Профлист',
                    ]),
                'type'
            )
            ->create();

        $response = $this->get('api/v1/fences');

        $response->assertStatus(200);

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
        Fence::factory()
            ->for(
                $fenceType = FenceType::factory()
                    ->create([
                        'name' => 'Профлист',
                    ]),
                'type'
            )
            ->create();

        $fenceSpec = FenceSpec::factory()
            ->for(
                $fenceType,
                'fence'
            )
            ->create([
                'height' => 2000,
                'width' => 1000,
            ]);

        $queryParams = http_build_query([
            'typeId' => $fenceType->id,
            'height' => $fenceSpec->height / 1000,
        ]);

        $response = $this->get("api/v1/fences?$queryParams");

        $response->assertStatus(200);

        $response->assertJsonCount(1, 'data');
    }

    public function testWithFiltersError()
    {
        Fence::factory()
            ->for(
                $fenceType = FenceType::factory()
                    ->create([
                        'name' => 'Профлист',
                    ]),
                'type'
            )
            ->create();

        $queryParams = http_build_query([
            'typeId' => 'someString',
        ]);

        $response = $this->get("api/v1/fences?$queryParams");

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'error_message',
            'error_code',
            'error_context',
        ]);
    }
}
