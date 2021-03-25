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
        $admin_role = Role::where('slug', 'admin')->first();
        $admin_user = User::where('email', 'admin@example.com')->first();

        $user_role = new UserRole([
            'user_id' => $admin_user->id,
            'role_id' => $admin_role->id,
        ]);
        $user_role->save();
    }
}
