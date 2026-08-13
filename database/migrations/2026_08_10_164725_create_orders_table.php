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
            $table->string('status')->default('Pendiente de Pago'); // Pendiente de Pago, Cotizado, Confirmado, En producción, Entregado
            $table->string('payment_proof_path')->nullable();
            $table->string('product_code')->nullable();
            $table->string('reference_image_path')->nullable();
            $table->text('notes')->nullable();
            $table->string('sender_name')->nullable();
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->text('dedication_message')->nullable();
            $table->string('salesperson')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('image_url')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_time')->nullable();
            $table->text('delivery_address')->nullable();
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
