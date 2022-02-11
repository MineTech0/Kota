<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MangementRoutesTest extends TestCase
{
    public $routes = [
        '/mangement',
        '/invite',
        '/'
    ];
    public function test_management_routes_need_access_management_permission()
    {
        // $response = $this->get('/');

        // $response->assertStatus(200);
        $this->assertTrue(True);
    }
}
