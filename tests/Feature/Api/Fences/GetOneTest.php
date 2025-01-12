<?php

namespace Tests\Feature\Api\Fences;

use App\Models\Fence;
use App\Models\FenceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneTest extends TestCase
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

        $response = $this->get("api/v1/fences/$fence->id");

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
    }

    public function testError()
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

        $response = $this->get('api/v1/fences/1000');

        $response->assertNotFound();
    }
}
