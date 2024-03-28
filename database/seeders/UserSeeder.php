<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userOne = User::create([
            'name' => 'Admin',
            'surname' => 'Test',
            'email' => 'admin@lumenapi.com',
            'password' => Hash::make('123')
        ]);

        $userOne->assignRole('admin');

        $userTwo = User::create([
            'name' => 'User',
            'surname' => 'Test',
            'email' => 'user@lumenapi.com',
            'password' => Hash::make('123')
        ]);

        $userTwo->assignRole('user');

    }
}
