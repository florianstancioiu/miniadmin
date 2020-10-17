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
            ->call(UserSeeder::class)
            ->call(CategorySeeder::class)
            ->call(PageSeeder::class)
            ->call(PostSeeder::class)
            ->call(CommentSeeder::class);
    }
}
