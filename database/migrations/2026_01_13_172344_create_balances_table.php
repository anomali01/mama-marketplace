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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['seller', 'validator'])->comment('Tipe saldo: seller atau validator');
            $table->decimal('amount', 15, 2)->default(0)->comment('Total saldo');
            $table->decimal('pending', 15, 2)->default(0)->comment('Saldo yang sedang dalam proses withdrawal');
            $table->timestamps();
            
            $table->unique(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
