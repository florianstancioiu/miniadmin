<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'title' => 'Site Title',
                'key' => 'site-title',
                'value' => 'MiniAdmin',
                'type' => 'text',
                'deletable' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Site Tagline',
                'key' => 'site-tagline',
                'value' => 'A simple Laravel Admin',
                'type' => 'textarea',
                'deletable' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Favicon',
                'key' => 'site-favicon',
                'value' => 'settings/favicon.ico',
                'type' => 'image',
                'deletable' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Logo',
                'key' => 'site-logo',
                'value' => 'settings/logo.png',
                'type' => 'image',
                'deletable' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Default User Logo',
                'key' => 'site-user-logo',
                'value' => 'settings/user.png',
                'type' => 'image',
                'deletable' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Home Background',
                'key' => 'site-home-bg',
                'value' => 'settings/home-bg.jpg',
                'type' => 'image',
                'deletable' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Setting::insert($settings);
    }
}
