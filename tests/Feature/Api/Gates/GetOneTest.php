<?php

namespace Tests\Feature\Api\Gates;

use App\Models\Gate;
use App\Models\GateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $gate = Gate::factory()
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        $request = $this->get("/api/v1/gates/$gate->id");

        $request->assertSuccessful();

        $request->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
    }

    public function testError()
    {
        $gate = Gate::factory()
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        $request = $this->get('/api/v1/gates/1000');

        $request->assertNotFound();
    }
}
