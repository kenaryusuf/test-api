<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => \App\Constants\Role::ADMIN
            ],
            [
                'name' => \App\Constants\Role::USER
            ]
        ];

        foreach ($roles as $role) {
            if (Role::findByName($role['name'])) {
                continue;
            }

            Role::create($role);
        }
    }
}
