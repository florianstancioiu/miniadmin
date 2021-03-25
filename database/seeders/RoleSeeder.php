<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'title' => 'Guest',
                'slug' => 'guest',
            ],
        ];

        Role::insert($data);
    }
}
