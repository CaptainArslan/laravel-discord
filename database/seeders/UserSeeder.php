<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole(['admin', 'moderator', 'basic']);

        $user = User::create([
            'name' => 'Moderatore',
            'email' => 'moderator@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('moderator');

        $user = User::create([
            'name' => 'Ramsha Altaf',
            'email' => 'rimsha@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('moderator');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('basic');


        User::factory(200)->create()->each(function ($user) {
            $user->assignRole(['basic']);
        });
    }
}
