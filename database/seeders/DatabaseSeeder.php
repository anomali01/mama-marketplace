<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StudyProgramSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);

        $this->command->info('✅ Data test berhasil dibuat!');
        $this->command->info('');
        $this->command->info('📧 Akun Login:');
        $this->command->info('   Admin    : admin@mama.com / password123');
        $this->command->info('   User Test: test@mama.com / password123');
        $this->command->info('   Penjual  : budi@mama.com / password123');
        $this->command->info('   Penjual  : ani@mama.com / password123');
        $this->command->info('   Penjual  : citra@mama.com / password123');
        $this->command->info('   Penjual  : deni@mama.com / password123');
        $this->command->info('   Pembeli  : eka@mama.com / password123');
        $this->command->info('   Pembeli  : fajar@mama.com / password123');
    }
}
