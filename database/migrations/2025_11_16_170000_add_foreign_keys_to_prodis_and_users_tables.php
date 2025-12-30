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
        // Add foreign keys for MySQL/MariaDB
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('prodi_id')->references('id')->on('prodis')->nullOnDelete();
        });

        Schema::table('prodis', function (Blueprint $table) {
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
        });

        Schema::table('prodis', function (Blueprint $table) {
            $table->dropForeign(['validator_id']);
        });
    }
};
