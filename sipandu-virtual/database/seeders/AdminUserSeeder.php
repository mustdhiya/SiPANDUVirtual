<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sipandu.local'],
            [
                'name'        => 'Admin Pengawas',
                'password'    => Hash::make('admin123'),
                'role'        => User::ROLE_ADMIN,
                'is_approved' => true,
                'status'      => User::STATUS_ACTIVE,
                'nomor_wa'    => '081234567890',
            ]
        );
    }
}