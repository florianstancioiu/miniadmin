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
        User::factory(20)->create();

        User::factory(1)->create([
            'first_name' => 'Florian',
            'last_name' => 'Stancioiu',
            'email' => 'admin@example.com'
        ]);
    }
}
