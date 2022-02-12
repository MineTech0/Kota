<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Http\Response as HttpResponse;
use RoleSeeder;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
   
    public function test_equipment_routes_when_user_has_management_permission()
    {

        $user = User::factory()->create();
        $user->givePermissionTo('access_management');

        $response = $this->actingAs($user)
                         ->get('/equipment');

        $response->assertStatus(200);
        $user->delete();
    }
    public function test_equipment_route_when_user_has_not_management_permission()
    {
        
        $user = User::factory()->create();
        
        
        $response = $this->actingAs($user)
                         ->get('/equipment');
        
        $response->assertStatus(HttpResponse::HTTP_FORBIDDEN);
        $user->delete();
    }
    public function test_equipment_create_route()
    {

        $user = User::factory()->create();
        $user->givePermissionTo('access_management');

        $response = $this->actingAs($user)
                         ->get('/equipment/create');

        $response->assertStatus(200);
        $user->delete();
    }

}
