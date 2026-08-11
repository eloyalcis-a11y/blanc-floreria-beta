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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('client_name');
            $table->string('company');
            $table->string('material');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('status')->default('Cotizado'); // Cotizado, Confirmado, En producción, Entregado
            $table->string('payment_method')->nullable();
            $table->string('image_url')->nullable();
            $table->date('delivery_date')->nullable();
            $table->boolean('is_in_route')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
