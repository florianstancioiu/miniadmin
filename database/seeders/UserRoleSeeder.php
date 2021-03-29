<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Connect admin to role
        $admin_user = User::where('email', 'admin@example.com')->first();
        $admin_role = Role::where('slug', 'admin')->first();
        $admin_user->roles()->attach($admin_role->id);

        // Connect super user to role
        $super_user = User::where('email', 'super@example.com')->first();
        $super_role = Role::where('slug', 'super')->first();
        $super_user->roles()->attach($super_role->id);

        // Connect guest users to role
        $guest_users = User::where('id', '>', '2')->get();
        $guest_role = Role::where('slug', 'guest')->first();
        foreach($guest_users as $user) {
            $user->roles()->attach($guest_role->id);
        }
    }
}
