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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_street')->nullable()->after('delivery_time');
            $table->string('delivery_neighborhood')->nullable()->after('delivery_street');
            $table->string('delivery_zip')->nullable()->after('delivery_neighborhood');
            $table->text('delivery_references')->nullable()->after('delivery_zip');
            // Mantenemos delivery_address antiguo por si hay datos, pero ya no lo usaremos en el form
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_street', 'delivery_neighborhood', 'delivery_zip', 'delivery_references']);
        });
    }
};
