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
     * Admins can manage every post; authors can create posts and manage only their own.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
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
