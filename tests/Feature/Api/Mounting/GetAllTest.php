<?php

namespace Tests\Feature\Api\Mounting;

use App\Models\Mounting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        Mounting::factory(10)
            ->create();

        $response = $this->get('api/v1/mountings');

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);

        $response->assertJsonCount(10, 'data');
    }
}
