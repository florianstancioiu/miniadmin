<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

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
                'value' => 'MiniCMS',
                'type' => 'text',
                'deletable' => 0
            ],
            [
                'title' => 'Site Tagline',
                'key' => 'site-tagline',
                'value' => 'A simple Laravel based CMS',
                'type' => 'textarea',
                'deletable' => 0
            ],
            [
                'title' => 'Favicon',
                'key' => 'site-favicon',
                'value' => 'settings/favicon.ico',
                'type' => 'image',
                'deletable' => 0
            ],
            [
                'title' => 'Logo',
                'key' => 'site-logo',
                'value' => 'settings/logo.png',
                'type' => 'image',
                'deletable' => 0
            ],
            [
                'title' => 'Home Background',
                'key' => 'site-home-bg',
                'value' => 'settings/home-bg.jpg',
                'type' => 'image',
                'deletable' => 0
            ]
	    ];

        Setting::insert($settings);
    }
}
