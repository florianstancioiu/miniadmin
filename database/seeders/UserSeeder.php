<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com'
        ]);

        User::factory(1)->create([
            'first_name' => 'Super',
            'last_name' => 'User',
            'email' => 'super@example.com'
        ]);

        User::factory(20)->create();
    }
}
