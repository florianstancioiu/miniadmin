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
            ->call(UserRolePermissionSeeder::class)
            ->call(CategorySeeder::class)
            ->call(PageSeeder::class)
            ->call(PostSeeder::class)
            ->call(SettingSeeder::class)
            ;
    }
}
