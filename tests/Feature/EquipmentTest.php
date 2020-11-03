<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response as HttpResponse;
use RoleSeeder;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_equipment_routes_when_user_has_management_permission()
    {

        $user = factory(User::class)->create();
        $user->givePermissionTo('access_management');

        $response = $this->actingAs($user)
                         ->get('/equipment');

        $response->assertStatus(200);
        $user->delete();
    }
    public function test_equipment_route_when_user_has_not_management_permission()
    {
        
        $user = factory(User::class)->create();
        
        
        $response = $this->actingAs($user)
                         ->get('/equipment');
        
        $response->assertStatus(HttpResponse::HTTP_FORBIDDEN);
        $user->delete();
    }
    public function test_equipment_create_route()
    {

        $user = factory(User::class)->create();
        $user->givePermissionTo('access_management');

        $response = $this->actingAs($user)
                         ->get('/equipment/create');

        $response->assertStatus(200);
        $user->delete();
    }

}
