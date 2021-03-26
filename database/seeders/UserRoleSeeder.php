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
        $user_role = new UserRole([
            'user_id' => $admin_user->id,
            'role_id' => $admin_role->id,
        ]);
        $user_role->save();

        // Connect super user to role
        $super_user = User::where('email', 'super@example.com')->first();
        $super_role = Role::where('slug', 'super')->first();
        $user_role = new UserRole([
            'user_id' => $super_user->id,
            'role_id' => $super_role->id,
        ]);
        $user_role->save();
    }
}
