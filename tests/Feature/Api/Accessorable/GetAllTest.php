<?php

namespace Tests\Feature\Api\Accessorable;

use App\Core\Error;
use App\Enum\AccessoryableType;
use App\Models\Accessory;
use App\Models\Accessoryable;
use App\Models\AccessorySpec;
use App\Models\Gate;
use App\Models\GateType;
use App\Models\Measurement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $accessoryableType = AccessoryableType::Gate;

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
                'accessoryable_type' => $accessoryableType->getModel(),
                'accessoryable_id' => $gate->id,
            ]);

        $response = $this->get('api/v1/accessories');

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }

    public function testWithFilter()
    {
        $accessoryableTypeGate = AccessoryableType::Gate;
        $accessoryableTypeFence = AccessoryableType::Fence;

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

        $queryParams = http_build_query([
            'accessoriableType' => $accessoryableTypeGate->value,
        ]);

        $response = $this->get("api/v1/accessories?$queryParams");

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);

        $queryParams = http_build_query([
            'accessoriableType' => $accessoryableTypeFence->value,
        ]);

        $response = $this->get("api/v1/accessories?$queryParams");

        $response->assertSuccessful();

        $response->assertJsonCount(0, 'data');
    }

    public function testWithFilterError()
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

        $queryParams = http_build_query([
            'accessoriableType' => 'invalid',
        ]);

        $response = $this->get("api/v1/accessories?$queryParams");

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'error_message',
            'error_code',
            'error_context',
        ]);

        $response->assertJsonPath('error_code', Error::INVALID_INPUT->name);
    }
}
