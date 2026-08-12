<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Parent
        User::updateOrCreate(
            ['email' => 'parent@example.com'],
            [
                'name'     => 'Parent Utama',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_PARENT,
            ]
        );

        // Child 1
        User::updateOrCreate(
            ['email' => 'anak1@example.com'],
            [
                'name'     => 'Anak Pertama',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_CHILD,
            ]
        );

        // Child 2 (opsional)
        User::updateOrCreate(
            ['email' => 'anak2@example.com'],
            [
                'name'     => 'Anak Kedua',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_CHILD,
            ]
        );
    }
}