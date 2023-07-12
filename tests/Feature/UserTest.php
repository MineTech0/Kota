<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_roles_can_be_added()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['assign_delete_user_role', 'access_management']);

        $editableUser = User::factory()->create();

        $roles = Role::where('name', '!=', 'super-admin')->get();

        $selectedRoles = $roles->random(2);

        //assert that the user has no roles
        $this->assertDatabaseMissing('model_has_roles', [
            'model_id' => $editableUser->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(
                '/users/' . $editableUser->id . '/roles',
                [
                    'roles' => $selectedRoles->pluck('id')->toArray(),
                ]
            );

        $response->assertSuccessful();
        //database assertion
        foreach ($selectedRoles as $role) {
            $this->assertDatabaseHas('model_has_roles', [
                'role_id' => $role->id,
                'model_id' => $editableUser->id,
            ]);
        }
    }

    public function test_user_roles_can_be_deleted()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['assign_delete_user_role', 'access_management']);

        $editableUser = User::factory()->create();

        $roles = Role::where('name', '!=', 'super-admin')->get();

        $selectedRoles = $roles->random(2);

        $editableUser->assignRole($selectedRoles);

        //assert that the user has roles
        foreach ($selectedRoles as $role) {
            $this->assertDatabaseHas('model_has_roles', [
                'role_id' => $role->id,
                'model_id' => $editableUser->id,
            ]);
        }

        $response = $this
            ->actingAs($user)
            ->patch(
                '/users/' . $editableUser->id . '/roles',
                [
                    'roles' => [],
                ]
            );

        $response->assertSuccessful();
        //database assertion
        foreach ($selectedRoles as $role) {
            $this->assertDatabaseMissing('model_has_roles', [
                'role_id' => $role->id,
                'model_id' => $editableUser->id,
            ]);
        }
    }

    function test_super_admin_cannot_be_edited()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['assign_delete_user_role', 'access_management']);

        $editableUser = User::factory()->create();
        $editableUser->assignRole('super-admin');

        $response = $this
            ->actingAs($user)
            ->patch(
                '/users/' . $editableUser->id . '/roles',
                [
                    'roles' => [],
                ]
            );

        $response->assertForbidden();
    }

    function test_user_can_be_deleted()
    {
        $user = User::factory()->create();
        $user->givePermissionTo(['delete_user', 'access_management']);

        $editableUser = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(
                '/users/' . $editableUser->id,
            );

        $response->assertSuccessful();
        $this->assertDatabaseMissing('users', [
            'id' => $editableUser->id,
        ]);
    }

    function test_user_cannot_be_deleted_without_permission() {
        $user = User::factory()->create();

        $editableUser = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(
                '/users/' . $editableUser->id,
            );

        $response->assertForbidden();
        $this->assertDatabaseHas('users', [
            'id' => $editableUser->id,
        ]);
    }

    function test_user_cannot_be_edited_without_permission() {
        $user = User::factory()->create();

        $editableUser = User::factory()->create();
        $role = Role::where('name', '!=', 'super-admin')->first();
        $editableUser->assignRole($role);

        $response = $this
            ->actingAs($user)
            ->patch(
                '/users/' . $editableUser->id . '/roles',
                [
                    'roles' => [],
                ]
            );

        $response->assertForbidden();

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $role->id,
            'model_id' => $editableUser->id,
        ]);
        
    }
}
