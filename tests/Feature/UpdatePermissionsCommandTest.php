<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class UpdatePermissionsCommandTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = false;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_removes_role_when_deleted_from_config()
    {
        //change config
        $config = [
            'management' => [],
            'signatory' => [],
        ];
        Config::set('kota.roles', $config);

        //seed
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

        //management roles exists
        $this->assertDatabaseHas('roles', [
            'name' => 'management'
        ]);

        //remove role
        $rolesConfig = [
            'signatory' => [],
        ];
        Config::set('kota.roles', $rolesConfig);

        //run command
        $this->artisan('update:roles');

        //management role does not exist
        $this->assertDatabaseMissing('roles', [
            'name' => 'management'
        ]);
    }

    public function test_removes_permission_when_deleted_from_config()
    {
        //change config
        $config = [
            'access_management',
            'see_equipment',
        ];
        Config::set('kota.permissions', $config);

        $rolesConfig = [
            'management' => [
                'access_management',
            ],
        ];

        Config::set('kota.roles', $rolesConfig);

        //reseed roles
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

        //management permission exists
        $this->assertDatabaseHas('permissions', [
            'name' => 'access_management'
        ]);

        //remove permission
        $permissionsConfig = [
            'see_equipment',
        ];
        Config::set('kota.permissions', $permissionsConfig);

        $rolesConfig = [
            'management' => [],
        ];

        Config::set('kota.roles', $rolesConfig);

        //run command
        $this->artisan('update:roles');

        //management permission does not exist
        $this->assertDatabaseMissing('permissions', [
            'name' => 'access_management'
        ]);
    }

    public function test_adds_role_when_added_to_config()
    {
        //change config
        $config = [
            'signatory' => [],
        ];
        Config::set('kota.roles', $config);

        //seed
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

        //add role
        $rolesConfig = [
            'management' => [],
            'signatory' => [],
        ];
        Config::set('kota.roles', $rolesConfig);

        //run command
        $this->artisan('update:roles');

        //management role does exist
        $this->assertDatabaseHas('permissions', [
            'name' => 'access_management'
        ]);
    }
}
