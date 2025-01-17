<?php

namespace Tests\Feature\Api\Clients;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateOneTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $postData = [
            'name' => 'Test Client',
            'phoneNumber' => '1234567890',
            'telegramId' => 1111111,
        ];

        $response = $this->post('api/v1/clients', $postData);

        $response->assertSuccessful();
    }
}
