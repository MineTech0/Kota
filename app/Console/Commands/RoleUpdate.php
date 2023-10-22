<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates roles and permissions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Get existing roles and permissions
        $existingRoles = Role::all();
        $existingPermissions = Permission::all();

        // Determine roles to delete
        $rolesToDelete = $existingRoles->filter(function ($role) {
            return !in_array($role->name, array_keys(config('kota.roles')));
        });

        // remove super-admin from roles to delete
        $rolesToDelete = $rolesToDelete->filter(function ($role) {
            return $role->name != 'super-admin';
        });

        // Determine permissions to delete
        $permissionsToDelete = $existingPermissions->filter(function ($permission) {
            return !in_array($permission->name, config('kota.permissions'));
        });

        // Clear non-preserved roles and permissions
        Role::whereIn('id', $rolesToDelete->pluck('id'))->delete();
        $this->info('Deleted roles: ' . $rolesToDelete->pluck('name')->implode(', '));

        Permission::whereIn('id', $permissionsToDelete->pluck('id'))->delete();
        $this->info('Deleted permissions: ' . $permissionsToDelete->pluck('name')->implode(', '));

        // Create new permissions
        collect(config('kota.permissions'))
            ->reject(function ($permissionName) use ($existingPermissions) {
                return $existingPermissions->contains('name', $permissionName);
            })
            ->each(function ($permissionName) {
                Permission::create(['name' => $permissionName]);
                $this->info('Created permission: ' . $permissionName);
            });

        //update super-admin permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->syncPermissions(Permission::all());

        // Create new roles and assign permissions
        collect(config('kota.roles'))
            ->each(function ($permissions, $roleName) use ($existingRoles){
                if($existingRoles->contains('name', $roleName)) {
                    $role = Role::findByName($roleName);
                    $role->syncPermissions($permissions);
                }
                else {
                    $role = Role::create(['name' => $roleName]);
                    $this->info('Created role: ' . $roleName);
                    $role->syncPermissions($permissions);
                }
            });

        $this->info('Roles and permissions synchronized.');
        return Command::SUCCESS;
    }
}
