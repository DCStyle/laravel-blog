<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Laravel blog'],
            ['key' => 'site_description', 'value' => 'My laravel blog website'],
            ['key' => 'site_meta_keywords', 'value' => 'laravel, blog, website'],
            ['key' => 'contact_email', 'value' => 'admin@example.com'],
            ['key' => 'copyright_text', 'value' => '© 2024 Laravel Blog. All rights reserved.'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/#'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/#'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/#'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/#'],
        ];

        DB::table('settings')->insert($settings);
    }
}
