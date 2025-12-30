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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // chat, order, promo, system, product
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // icon name or emoji
            $table->string('image')->nullable(); // product/user image
            $table->string('action_url')->nullable(); // URL to redirect
            $table->json('data')->nullable(); // additional data (order_id, product_id, etc)
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
