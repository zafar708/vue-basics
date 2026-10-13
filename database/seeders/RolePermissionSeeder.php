<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Create the post permissions and the roles that hold them.
     *
     * Admins can view and manage every post; authors can create posts and
     * view and manage only their own.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'edit own posts',
            'delete own posts',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        Role::findOrCreate('admin')->syncPermissions([
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
        ]);

        Role::findOrCreate('author')->syncPermissions([
            'create posts',
            'edit own posts',
            'delete own posts',
        ]);
    }
}
