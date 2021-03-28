<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add permissions for the admin role
        $admin_permissions = Permission::all();
        $admin_role = Role::where('slug', 'admin')->first();

        $data = [];
        foreach ($admin_permissions as $permission) {
            $data[] = [
                'permission_id' => $permission->id,
                'role_id' => $admin_role->id,
            ];
        }

        RolePermission::insert($data);

        // Add permissions for the super role
        $super_permissions = Permission::whereIn('slug', [
            'list-dashboard',
            'list-posts',
            'create-posts',
            'store-posts',
            'edit-posts',
            'update-posts',
            'destroy-posts',
            'list-categories',
            'create-categories',
            'store-categories',
            'edit-categories',
            'update-categories',
            'destroy-categories',
            'list-tags',
            'create-tags',
            'store-tags',
            'edit-tags',
            'update-tags',
            'destroy-tags',
            'list-media',
            'create-media',
            'store-media',
            'edit-media',
            'update-media',
            'destroy-media',
        ])->get();
        $super_role = Role::where('slug', 'super')->first();

        $data = [];
        foreach ($super_permissions as $permission) {
            $data[] = [
                'permission_id' => $permission->id,
                'role_id' => $super_role->id,
            ];
        }

        RolePermission::insert($data);
    }
}
