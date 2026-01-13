<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin default jika belum ada
        User::updateOrCreate(
            ['email' => 'admin@mama.com'],
            [
                'name' => 'Admin MAMA',
                'email' => 'admin@mama.com',
                'password' => Hash::make('admin123'), // Password: admin123
                'role' => 'admin',
                'verified' => true,
            ]
        );

        $this->command->info('Admin berhasil dibuat!');
        $this->command->info('Email: admin@mama.com');
        $this->command->info('Password: admin123');
    }
}
