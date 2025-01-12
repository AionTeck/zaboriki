<?php

namespace Tests\Feature\Api\Fences;

use App\Models\Fence;
use App\Models\FenceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetTypesTest extends TestCase
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

        $response = $this->get('api/v1/fences/types');

        $response->assertStatus(200);

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
