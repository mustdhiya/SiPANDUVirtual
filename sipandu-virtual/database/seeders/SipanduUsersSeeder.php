<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SipanduUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin (Atasan Tertinggi & Pengawas PAI)
        User::updateOrCreate(
            ['email' => 'baqi.superadmin@sipandu.id'],
            [
                'name'                => 'Baqi Nurul Hakkurahmy, M.Pd',
                'password'            => Hash::make('123456'),
                'password_plain'      => '123456',
                'role'                => User::ROLE_ADMIN,
                'status'              => User::STATUS_ACTIVE,
                'is_approved'         => true,
                'is_profile_complete' => true,
                'nip'                 => '197805122005012003',
                'nomor_wa'            => '081254000001',
                'jabatan_pengawas'    => 'Pengawas PAI Madya (Super Admin)',
                'wilayah_binaan'      => 'Kota Samarinda',
            ]
        );

        // 2. Demo Pengawas PAI (Non-Super Admin)
        User::updateOrCreate(
            ['email' => 'pengawas.demo@sipandu.id'],
            [
                'name'                => 'Drs. H. Rahmat Hidayat, M.Pd',
                'password'            => Hash::make('123456'),
                'password_plain'      => '123456',
                'role'                => User::ROLE_PENGAWAS,
                'status'              => User::STATUS_ACTIVE,
                'is_approved'         => true,
                'is_profile_complete' => true,
                'nip'                 => '197503182003121002',
                'nomor_wa'            => '081254000002',
                'jabatan_pengawas'    => 'Pengawas PAI SMA/SMK',
                'wilayah_binaan'      => 'Kota Samarinda',
            ]
        );

        // 3. Demo Guru Binaan (Disetujui, siap melengkapi profil & pilih pengawas)
        User::updateOrCreate(
            ['email' => 'guru.demo@sipandu.id'],
            [
                'name'                => 'Siti Aminah, S.Pd.I',
                'password'            => Hash::make('123456'),
                'password_plain'      => '123456',
                'role'                => User::ROLE_GURU,
                'status'              => User::STATUS_ACTIVE,
                'is_approved'         => true,
                'is_profile_complete' => false,
                'nip'                 => '198604102010012015',
                'nomor_wa'            => '081254000003',
            ]
        );
    }
}
