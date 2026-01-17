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
        
        // ==========================================
        // ADMIN USER
        // Email: admin@mama.com, Password: password123
        // ==========================================
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

        // ==========================================
        // VALIDATOR UNTUK SEMUA PRODI
        // Email: validator.[kode_prodi]@student.ac.id
        // Password: validator123
        // ==========================================
        $validatorData = [
            ['code' => 'TI', 'name' => 'Dr. Hendra Wijaya', 'nim' => '19001001'],
            ['code' => 'SI', 'name' => 'Dr. Rina Susanti', 'nim' => '19001002'],
            ['code' => 'TE', 'name' => 'Dr. Ahmad Fauzi', 'nim' => '19001003'],
            ['code' => 'TM', 'name' => 'Dr. Bambang Susilo', 'nim' => '19001004'],
            ['code' => 'TS', 'name' => 'Dr. Dewi Kartika', 'nim' => '19001005'],
            ['code' => 'AK', 'name' => 'Dr. Siti Rahayu', 'nim' => '19001006'],
            ['code' => 'MN', 'name' => 'Dr. Joko Widodo', 'nim' => '19001007'],
            ['code' => 'IK', 'name' => 'Dr. Maya Sari', 'nim' => '19001008'],
            ['code' => 'DKV', 'name' => 'Dr. Andi Pratama', 'nim' => '19001009'],
            ['code' => 'PS', 'name' => 'Dr. Lina Marlina', 'nim' => '19001010'],
            ['code' => 'HK', 'name' => 'Dr. Teguh Santoso', 'nim' => '19001011'],
            ['code' => 'KD', 'name' => 'Dr. Ratna Dewi', 'nim' => '19001012'],
            ['code' => 'FA', 'name' => 'Dr. Agus Setiawan', 'nim' => '19001013'],
            ['code' => 'AR', 'name' => 'Dr. Fitri Handayani', 'nim' => '19001014'],
            ['code' => 'SIG', 'name' => 'Dr. John Smith', 'nim' => '19001015'],
        ];

        foreach ($validatorData as $index => $validator) {
            $prodi = $prodis->where('code', $validator['code'])->first();
            if ($prodi) {
                $emailCode = strtolower($validator['code']);
                User::updateOrCreate(
                    ['email' => "validator.{$emailCode}@student.ac.id"],
                    [
                        'name' => $validator['name'],
                        'email' => "validator.{$emailCode}@student.ac.id",
                        'password' => Hash::make('validator123'),
                        'role' => 'validator',
                        'nim' => $validator['nim'],
                        'prodi' => $prodi->name,
                        'phone' => '0811' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                        'verified' => true,
                        'validator_prodi_id' => $prodi->id,
                        'bank_name' => 'BCA',
                        'account_number' => '123456' . str_pad($prodi->id, 4, '0', STR_PAD_LEFT),
                        'account_holder_name' => $validator['name'],
                    ]
                );
            }
        }

        // ==========================================
        // PENJUAL UNTUK SEMUA PRODI
        // Email: seller.[kode_prodi]@mama.com
        // Password: seller123
        // ==========================================
        $sellerData = [
            ['code' => 'TI', 'name' => 'Budi Santoso', 'nim' => '20211001', 'shop' => 'Tech Corner TI'],
            ['code' => 'SI', 'name' => 'Ani Wijaya', 'nim' => '20211002', 'shop' => 'Digital Store SI'],
            ['code' => 'TE', 'name' => 'Candra Elektro', 'nim' => '20211003', 'shop' => 'Elektro Mart'],
            ['code' => 'TM', 'name' => 'Dedi Mekanik', 'nim' => '20211004', 'shop' => 'Mesin Jaya'],
            ['code' => 'TS', 'name' => 'Eko Sipil', 'nim' => '20211005', 'shop' => 'Sipil Store'],
            ['code' => 'AK', 'name' => 'Fani Akuntan', 'nim' => '20211006', 'shop' => 'Akuntansi Shop'],
            ['code' => 'MN', 'name' => 'Gita Manager', 'nim' => '20211007', 'shop' => 'Manajemen Mart'],
            ['code' => 'IK', 'name' => 'Hani Komunikasi', 'nim' => '20211008', 'shop' => 'Komunikasi Corner'],
            ['code' => 'DKV', 'name' => 'Ivan Desainer', 'nim' => '20211009', 'shop' => 'Design Gallery DKV'],
            ['code' => 'PS', 'name' => 'Jeni Psikolog', 'nim' => '20211010', 'shop' => 'Psikologi Shop'],
            ['code' => 'HK', 'name' => 'Kevin Hukum', 'nim' => '20211011', 'shop' => 'Law Store'],
            ['code' => 'KD', 'name' => 'Lina Medis', 'nim' => '20211012', 'shop' => 'Medika Shop'],
            ['code' => 'FA', 'name' => 'Mira Farmasi', 'nim' => '20211013', 'shop' => 'Farmasi Corner'],
            ['code' => 'AR', 'name' => 'Nanda Arsitek', 'nim' => '20211014', 'shop' => 'Arsitek Store'],
            ['code' => 'SIG', 'name' => 'Oscar English', 'nim' => '20211015', 'shop' => 'English Book Store'],
        ];

        foreach ($sellerData as $index => $seller) {
            $prodi = $prodis->where('code', $seller['code'])->first();
            if ($prodi) {
                $emailCode = strtolower($seller['code']);
                User::updateOrCreate(
                    ['email' => "seller.{$emailCode}@mama.com"],
                    [
                        'name' => $seller['name'],
                        'email' => "seller.{$emailCode}@mama.com",
                        'password' => Hash::make('seller123'),
                        'role' => 'mahasiswa',
                        'nim' => $seller['nim'],
                        'prodi' => $prodi->name,
                        'phone' => '0821' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                        'verified' => true,
                        'shop_name' => $seller['shop'],
                        'shop_description' => "Toko {$seller['shop']} menyediakan berbagai kebutuhan mahasiswa {$prodi->name}",
                        'shop_address' => "Kampus Gedung {$prodi->code}, Lantai " . (($index % 3) + 1),
                        'seller_bank_name' => 'BCA',
                        'seller_account_number' => '789012' . str_pad($prodi->id, 4, '0', STR_PAD_LEFT),
                        'seller_account_holder_name' => $seller['name'],
                    ]
                );
            }
        }

        // ==========================================
        // PEMBELI UNTUK TESTING
        // Email: buyer@mama.com, Password: buyer123
        // ==========================================
        $buyerData = [
            ['code' => 'TI', 'name' => 'Pembeli TI', 'nim' => '20221001'],
            ['code' => 'SI', 'name' => 'Pembeli SI', 'nim' => '20221002'],
            ['code' => 'TE', 'name' => 'Pembeli TE', 'nim' => '20221003'],
            ['code' => 'TM', 'name' => 'Pembeli TM', 'nim' => '20221004'],
            ['code' => 'TS', 'name' => 'Pembeli TS', 'nim' => '20221005'],
        ];

        foreach ($buyerData as $index => $buyer) {
            $prodi = $prodis->where('code', $buyer['code'])->first();
            if ($prodi) {
                $emailCode = strtolower($buyer['code']);
                User::updateOrCreate(
                    ['email' => "buyer.{$emailCode}@mama.com"],
                    [
                        'name' => $buyer['name'],
                        'email' => "buyer.{$emailCode}@mama.com",
                        'password' => Hash::make('buyer123'),
                        'role' => 'mahasiswa',
                        'nim' => $buyer['nim'],
                        'prodi' => $prodi->name,
                        'phone' => '0831' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                        'verified' => true,
                    ]
                );
            }
        }

        $this->command->info('');
        $this->command->info('✅ User seeding berhasil!');
        $this->command->info('');
        $this->command->info('=== KREDENSIAL LOGIN ===');
        $this->command->info('');
        $this->command->info('👑 ADMIN:');
        $this->command->info('   Email: admin@mama.com | Password: password123');
        $this->command->info('');
        $this->command->info('✅ VALIDATOR (15 prodi):');
        $this->command->info('   Email: validator.[kode_prodi]@student.ac.id | Password: validator123');
        $this->command->info('   Contoh: validator.ti@student.ac.id');
        $this->command->info('');
        $this->command->info('🛒 PENJUAL (15 prodi):');
        $this->command->info('   Email: seller.[kode_prodi]@mama.com | Password: seller123');
        $this->command->info('   Contoh: seller.ti@mama.com');
        $this->command->info('');
        $this->command->info('🛍️ PEMBELI (5 prodi):');
        $this->command->info('   Email: buyer.[kode_prodi]@mama.com | Password: buyer123');
        $this->command->info('   Contoh: buyer.ti@mama.com');
        $this->command->info('');
    }
}
