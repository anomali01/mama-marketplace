<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            ['name' => 'Teknik Informatika', 'code' => 'TI'],
            ['name' => 'Sistem Informasi', 'code' => 'SI'],
            ['name' => 'Teknik Elektro', 'code' => 'TE'],
            ['name' => 'Teknik Mesin', 'code' => 'TM'],
            ['name' => 'Teknik Sipil', 'code' => 'TS'],
            ['name' => 'Akuntansi', 'code' => 'AK'],
            ['name' => 'Manajemen', 'code' => 'MN'],
            ['name' => 'Ilmu Komunikasi', 'code' => 'IK'],
            ['name' => 'Desain Komunikasi Visual', 'code' => 'DKV'],
            ['name' => 'Psikologi', 'code' => 'PS'],
            ['name' => 'Hukum', 'code' => 'HK'],
            ['name' => 'Kedokteran', 'code' => 'KD'],
            ['name' => 'Farmasi', 'code' => 'FA'],
            ['name' => 'Arsitektur', 'code' => 'AR'],
            ['name' => 'Sastra Inggris', 'code' => 'SIG'],
        ];

        foreach ($programs as $program) {
            StudyProgram::updateOrCreate(
                ['code' => $program['code']],
                $program
            );
        }
    }
}
