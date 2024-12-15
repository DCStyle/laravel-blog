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
        $this->call([
            CreateAdminUserSeeder::class,
            CategoriesSeeder::class,
            SettingsSeeder::class
        ]);

        \App\Models\Post::factory(50)->create();

        $this->call([
            HighlightPostSeeder::class,
        ]);
    }
}
