<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'firstname' => 'Admin',
            'lastname' => 'Administrator',
            'email' => 'admin@db.com',
            'image_path' => '/images/avatars/user.png',
            'password' => bcrypt('admin1234'),
        ]);
    }
}
