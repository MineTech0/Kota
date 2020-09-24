<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicPermissionTest extends TestCase
{

    public function test_Management_Route_Access_Without_Authentication()
    {
        $user = factory(User::class)->create();

         $response = $this->actingAs($user)
                         ->get('/management');

        $response->assertStatus(403);
    }
}