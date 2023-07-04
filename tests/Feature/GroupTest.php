<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_group()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('access_management');
        $group = Group::factory()->make();
        $group['leaders'] = [User::factory()->create()->toArray()];
        $response = $this->actingAs($user)
            ->post('/groups', $group->toArray());
        $response->assertStatus(Response::HTTP_CREATED);
        $createdGroup = Group::where('name', $group->name)->first();
        $this->assertNotNull($createdGroup);
        $this->assertEquals($group->leaders[0]['id'], $createdGroup->leaders()->first()->toArray()['id']);
    }

    public function test_create_group_without_permission()
    {
        $user = User::factory()->create();
        $group = Group::factory()->make();
        $group['leaders'] = [User::factory()->create()->toArray()];
        $response = $this->actingAs($user)
            ->post('/groups', $group->toArray());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_delete_group()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('access_management');
        $group = Group::factory()->create();
        $response = $this->actingAs($user)
            ->delete('/groups/' . $group->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertNull(Group::find($group->id));
    }

    public function test_delete_group_without_permission()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $response = $this->actingAs($user)
            ->delete('/groups/' . $group->id);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_update_group(){
        $user = User::factory()->create();
        $user->givePermissionTo('access_management');
        $group = Group::factory()->create();
        $group->load('leaders');
        $group->name = 'new name';
        $group->leaders->push(User::factory()->create()->toArray());
        $response = $this->actingAs($user)
            ->put('/groups/' . $group->id, $group->toArray());
        $response->assertStatus(Response::HTTP_OK);
        $updatedGroup = Group::find($group->id);
        $this->assertEquals($group->name, $updatedGroup->name);
    }

    public function test_update_group_without_permission(){
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $group->name = 'new name';
        $response = $this->actingAs($user)
            ->put('/groups/' . $group->id, $group->toArray());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

}
