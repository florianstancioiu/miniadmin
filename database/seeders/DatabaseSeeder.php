<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this
            ->call(RoleSeeder::class)
            ->call(UserSeeder::class)
            ->call(CategorySeeder::class)
            ->call(PageSeeder::class)
            ->call(PostSeeder::class)
            ->call(SettingSeeder::class)
            ->call(PermissionSeeder::class)
            ->call(RolePermissionSeeder::class)
            ->call(UserRoleSeeder::class)
            ;
    }
}
