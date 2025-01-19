<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $data = json_decode(file_get_contents(resource_path('calculation.json')), true);

        $response = $this->post('api/v1/calculations', $data);

        config()->set('queue.default', 'sync');

        $response->dump();
    }
}
