<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        collect(config('kota.permissions'))
            ->each(function (string $permissionName) {
                Permission::create(['name' => $permissionName]);
            });


        // create roles and assign created permissions
        collect(config('kota.roles'))
            ->each(function (array $permissions, string $roleName) {
                Role::create(['name' => $roleName])
                    ->givePermissionTo($permissions);
            });

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

    }
}
