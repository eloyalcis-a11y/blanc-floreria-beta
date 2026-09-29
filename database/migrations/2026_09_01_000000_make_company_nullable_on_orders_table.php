<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * El campo "Empresa / Proyecto" es opcional en el formulario y la validacion ya
     * lo marca como nullable, pero la columna se creo NOT NULL. Como Laravel convierte
     * los inputs vacios en null (ConvertEmptyStringsToNull), dar de alta un pedido sin
     * empresa reventaba con "Column 'company' cannot be null".
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('company')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('orders')->whereNull('company')->update(['company' => '']);

        Schema::table('orders', function (Blueprint $table) {
            $table->string('company')->nullable(false)->change();
        });
    }
};
