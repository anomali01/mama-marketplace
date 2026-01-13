<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ValidatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data validator yang tidak valid (tidak ada prodi atau bank)
        $this->command->info('🗑️ Menghapus validator yang tidak valid...');
        
        User::where('role', 'validator')
            ->where(function($query) {
                $query->whereNull('validator_prodi_id')
                      ->orWhereNull('bank_name')
                      ->orWhereNull('nim');
            })
            ->delete();

        // Hapus validator dengan email tidak sesuai format
        User::where('role', 'validator')
            ->where('email', 'not like', '%@student.%')
            ->delete();

        $this->command->info('✅ Data tidak valid berhasil dihapus!');

        // Get semua prodi
        $prodis = StudyProgram::all();

        if ($prodis->isEmpty()) {
            $this->command->error('Tidak ada data prodi! Jalankan StudyProgramSeeder terlebih dahulu.');
            return;
        }

        $this->command->info('📝 Membuat validator untuk setiap prodi...');

        $validators = [];
        $password = 'validator123'; // Password yang sama untuk semua validator

        foreach ($prodis as $prodi) {
            // Cek apakah prodi sudah punya validator
            $existing = User::where('role', 'validator')
                ->where('validator_prodi_id', $prodi->id)
                ->where('verified', true)
                ->first();

            if ($existing) {
                $this->command->warn("⚠️  Prodi {$prodi->name} sudah memiliki validator: {$existing->email}");
                continue;
            }

            // Buat validator baru
            $validator = User::create([
                'name' => "Validator {$prodi->name}",
                'email' => strtolower(str_replace(' ', '', $prodi->code)) . "@student.uisi.ac.id",
                'password' => Hash::make($password),
                'role' => 'validator',
                'nim' => '2024' . str_pad($prodi->id, 6, '0', STR_PAD_LEFT),
                'validator_prodi_id' => $prodi->id,
                'phone' => '08' . rand(1000000000, 9999999999),
                'bank_name' => 'BCA',
                'account_number' => '1234567' . str_pad($prodi->id, 3, '0', STR_PAD_LEFT),
                'account_holder_name' => "Validator {$prodi->name}",
                'verified' => true, // Langsung verified untuk testing
            ]);

            $validators[] = [
                'prodi' => $prodi->name,
                'email' => $validator->email,
                'nim' => $validator->nim,
                'password' => $password
            ];
        }

        // Tampilkan kredensial
        $this->command->info("\n✅ Validator berhasil dibuat untuk " . count($validators) . " prodi!\n");
        $this->command->info("=== KREDENSIAL VALIDATOR ===");
        $this->command->info("Password untuk semua: {$password}\n");
        
        foreach ($validators as $val) {
            $this->command->info("📌 {$val['prodi']}");
            $this->command->info("   Email: {$val['email']}");
            $this->command->info("   NIM: {$val['nim']}");
            $this->command->info("");
        }
    }
}
