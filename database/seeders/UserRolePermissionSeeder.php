<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    protected $permissions = [
        'view dashboard',

        'view pages',
        'create pages',
        'edit own pages',
        'edit any pages',
        'update own pages',
        'update any pages',
        'delete own pages',
        'delete any pages',

        'view posts',
        'create posts',
        'edit own posts',
        'edit any posts',
        'update own posts',
        'update any posts',
        'delete own posts',
        'delete any posts',

        'view users',
        'create users',
        'edit own users',
        'edit any users',
        'update own users',
        'update any users',
        'delete own users',
        'delete any users',

        'view roles',
        'create roles',
        'edit own roles',
        'edit any roles',
        'update own roles',
        'update any roles',
        'delete own roles',
        'delete any roles',

        'view permissions',
        'create permissions',
        'edit own permissions',
        'edit any permissions',
        'update own permissions',
        'update any permissions',
        'delete own permissions',
        'delete any permissions',

        'view settings',
        'create settings',

        'edit profile',
        'update profile',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Permissions
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles
        $guest_role = Role::create(['name' => 'guest']);
        $this->addGuestPermissions($guest_role);
        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo($this->permissions);
        $super_admin_role = Role::create(['name' => 'super_admin']);

        // Create Users
        $guest_user = User::factory(1)->create([
            'first_name' => 'Guest',
            'last_name' => 'User',
            'email' => 'guest@example.com'
        ])->first();
        $admin_user = User::factory(1)->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com'
        ])->first();
        $super_admin_user = User::factory(1)->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'super@example.com'
        ])->first();

        // Assign Roles
        $guest_user->assignRole($guest_role);
        $admin_user->assignRole($admin_role);
        $super_admin_user->assignRole($super_admin_role);
    }

    protected function addGuestPermissions(Role $guest)
    {
        $guest->givePermissionTo([
            'view dashboard',

            'view posts',
            'create posts',
            'edit own posts',
            'update own posts',
            'delete own posts',

            'edit profile',
            'update profile',
        ]);
    }
}
