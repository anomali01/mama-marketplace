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
        Schema::table('products', function (Blueprint $table) {
            // Rename title to name
            $table->renameColumn('title', 'name');
            
            // Add new columns
            $table->enum('condition', ['new', 'used'])->default('new')->after('status');
            $table->string('location', 255)->nullable()->after('condition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->dropColumn(['condition', 'location']);
        });
    }
};
