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
        $permissions = Permission::all();
        $admin_role = Role::where('slug', 'admin')->first();

        $data = [];
        foreach($permissions as $permission) {
            $data[] = [
                'permission_id' => $permission->id,
                'role_id' => $admin_role->id,
            ];
        }

        RolePermission::insert($data);
    }
}
