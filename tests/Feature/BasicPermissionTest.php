<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_Management_Route_Access_Without_Authentication()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/management');

        $response->assertStatus(403);
    }
}