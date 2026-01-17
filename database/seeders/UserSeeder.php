<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua prodi
        $prodis = StudyProgram::all();
        
        // User Admin
        User::updateOrCreate(
            ['email' => 'admin@mama.com'],
            [
                'name' => 'Admin MAMA',
                'email' => 'admin@mama.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'nim' => '00000000',
                'prodi' => $prodis->first()->name ?? 'Informatika',
                'phone' => '081234567890',
                'verified' => true,
            ]
        );

        // User Test (Pembeli & Penjual)
        User::updateOrCreate(
            ['email' => 'test@mama.com'],
            [
                'name' => 'User Test',
                'email' => 'test@mama.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '12345678',
                'prodi' => $prodis->where('code', 'TI')->first()->name ?? 'Informatika',
                'phone' => '081234567891',
                'verified' => true,
            ]
        );

        // Penjual 1 - Elektronik
        User::updateOrCreate(
            ['email' => 'budi@mama.com'],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@mama.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '20210001',
                'prodi' => $prodis->where('code', 'TI')->first()->name ?? 'Informatika',
                'phone' => '081111111111',
                'verified' => true,
            ]
        );

        // Penjual 2 - Buku
        User::updateOrCreate(
            ['email' => 'ani@mama.com'],
            [
                'name' => 'Ani Wijaya',
                'email' => 'ani@mama.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '20210002',
                'prodi' => $prodis->where('code', 'SI')->first()->name ?? 'Sistem Informasi',
                'phone' => '082222222222',
                'verified' => true,
            ]
        );

        // Penjual 3 - Fashion
        User::updateOrCreate(
            ['email' => 'citra@mama.com'],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra@mama.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '20210003',
                'prodi' => $prodis->where('code', 'DKV')->first()->name ?? 'Desain Komunikasi Visual',
                'phone' => '083333333333',
                'verified' => true,
            ]
        );

        // Penjual 4 - Makanan
        User::updateOrCreate(
            ['email' => 'deni@mama.com'],
            [
                'name' => 'Deni Pratama',
                'email' => 'deni@mama.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '20210004',
                'prodi' => $prodis->where('code', 'MN')->first()->name ?? 'Manajemen',
                'phone' => '084444444444',
                'verified' => true,
            ]
        );

        // Pembeli 1
        User::updateOrCreate(
            ['email' => 'eka@mama.com'],
            [
                'name' => 'Eka Putri',
                'email' => 'eka@mama.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '20220001',
                'prodi' => $prodis->where('code', 'AK')->first()->name ?? 'Akuntansi',
                'phone' => '085555555555',
                'verified' => true,
            ]
        );

        // Pembeli 2
        User::updateOrCreate(
            ['email' => 'fajar@mama.com'],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar@mama.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '20220002',
                'prodi' => $prodis->where('code', 'TE')->first()->name ?? 'Elektro',
                'phone' => '086666666666',
                'verified' => true,
            ]
        );

        // ==========================================
        // VALIDATOR USERS
        // Email: @student.ac.id, Password: 12345678
        // ==========================================

        // Validator 1 - untuk Teknik Informatika
        User::updateOrCreate(
            ['email' => 'validator@student.ac.id'],
            [
                'name' => 'Validator Utama',
                'email' => 'validator@student.ac.id',
                'password' => Hash::make('12345678'),
                'role' => 'validator',
                'nim' => '19000001',
                'prodi' => $prodis->where('code', 'TI')->first()->name ?? 'Informatika',
                'phone' => '087777777777',
                'verified' => true,
                'validator_prodi_id' => $prodis->where('code', 'TI')->first()->id ?? 1,
            ]
        );

        // Validator 2 - untuk Sistem Informasi
        User::updateOrCreate(
            ['email' => 'validator2@student.ac.id'],
            [
                'name' => 'Rina Validator',
                'email' => 'validator2@student.ac.id',
                'password' => Hash::make('12345678'),
                'role' => 'validator',
                'nim' => '19000002',
                'prodi' => $prodis->where('code', 'SI')->first()->name ?? 'Sistem Informasi',
                'phone' => '088888888888',
                'verified' => true,
                'validator_prodi_id' => $prodis->where('code', 'SI')->first()->id ?? 2,
            ]
        );

        // Validator 3 - untuk Teknik Elektro
        User::updateOrCreate(
            ['email' => 'ahmad.validator@student.ac.id'],
            [
                'name' => 'Ahmad Validator',
                'email' => 'ahmad.validator@student.ac.id',
                'password' => Hash::make('12345678'),
                'role' => 'validator',
                'nim' => '19000003',
                'prodi' => $prodis->where('code', 'TE')->first()->name ?? 'Elektro',
                'phone' => '089999999999',
                'verified' => true,
                'validator_prodi_id' => $prodis->where('code', 'TE')->first()->id ?? 3,
            ]
        );
    }
}
