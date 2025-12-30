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
            // Drop foreign key if exists
            if (Schema::hasColumn('users', 'prodi_id')) {
                $table->dropForeign(['prodi_id']);
                $table->dropColumn('prodi_id');
            }
            
            // Add prodi as text field
            $table->string('prodi', 100)->nullable()->after('nim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('prodi');
            $table->foreignId('prodi_id')->nullable()->constrained('prodis')->nullOnDelete();
        });
    }
};
