<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BasicPermissionTest extends TestCase
{

    public function test_Management_Route_Access_Without_Authentication()
    {
        $response = $this->get('/management');

        $response->assertStatus(401);
    }
}
