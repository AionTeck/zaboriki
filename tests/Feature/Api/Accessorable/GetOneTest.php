<?php

namespace Tests\Feature\Api\Accessorable;

use App\Enum\AccessoryableType;
use App\Models\Accessory;
use App\Models\Accessoryable;
use App\Models\AccessorySpec;
use App\Models\Gate;
use App\Models\GateType;
use App\Models\Measurement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $accessoryableTypeGate = AccessoryableType::Gate;

        $gate = Gate::factory()
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        $accessory = Accessory::factory()
            ->has(
                AccessorySpec::factory(2),
                'specs'
            )

            ->create();

        Accessoryable::factory()
            ->for($accessory)
            ->create([
                'accessoryable_type' => $accessoryableTypeGate->getModel(),
                'accessoryable_id' => $gate->id,
            ]);

        $response = $this->get('api/v1/accessories/' . $accessory->id);

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
    }

    public function testNotFound()
    {
        $accessoryableTypeGate = AccessoryableType::Gate;

        $gate = Gate::factory()
            ->for(
                GateType::factory()
                    ->create(),
                'type'
            )
            ->create();

        $accessory = Accessory::factory()
            ->has(
                AccessorySpec::factory(2),
                'specs'
            )

            ->create();

        Accessoryable::factory()
            ->for($accessory)
            ->create([
                'accessoryable_type' => $accessoryableTypeGate->getModel(),
                'accessoryable_id' => $gate->id,
            ]);

        $response = $this->get('api/v1/accessories/' . 1000);

        $response->assertNotFound();
    }
}
