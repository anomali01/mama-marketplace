<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom prodi_id untuk validator (beda dengan prodi untuk mahasiswa)
            $table->unsignedBigInteger('validator_prodi_id')->nullable()->after('role');
            $table->foreign('validator_prodi_id')->references('id')->on('prodis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['validator_prodi_id']);
            $table->dropColumn('validator_prodi_id');
        });
    }
};
