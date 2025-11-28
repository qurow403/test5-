<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ユーザーA
        User::create([
            'name' => 'User A',
            'email' => 'userA@example.com',
            'password' => Hash::make('password123'),
        ]);

        // ユーザーB
        User::create([
            'name' => 'User B',
            'email' => 'userB@example.com',
            'password' => Hash::make('password123'),
        ]);

        // ユーザーC（商品を持たない）
        User::create([
            'name' => 'User C',
            'email' => 'userC@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
