<?php

namespace Tests\Feature\Api\Mounting;

use App\Models\Mounting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        Mounting::factory(10)
            ->create();

        $response = $this->get('api/v1/mountings/' . Mounting::first()->id);

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                    'id',
                    'name',
            ],
        ]);

        $response->assertJsonPath('data.id', Mounting::first()->id);
    }
}
