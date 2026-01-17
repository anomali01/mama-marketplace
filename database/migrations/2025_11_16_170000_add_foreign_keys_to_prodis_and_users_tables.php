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
        // Note: users.prodi_id foreign key is already defined in create_users_table migration
        
        Schema::table('prodis', function (Blueprint $table) {
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: users.prodi_id foreign key is dropped in create_users_table migration
        
        Schema::table('prodis', function (Blueprint $table) {
            $table->dropForeign(['validator_id']);
        });
    }
};
