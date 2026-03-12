<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'testuser1',
                'email' => 'test1@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'img_url' => 'https://via.placeholder.com/150',
            ],
            [
                'id' => 2,
                'name' => 'testuser2',
                'email' => 'test2@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => null,
                'img_url' => 'https://via.placeholder.com/150',
            ],
            [
                'id' => 3,
                'name' => 'testuser3',
                'email' => 'test3@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'img_url' => 'https://via.placeholder.com/150',
            ],
        ];

        foreach($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}