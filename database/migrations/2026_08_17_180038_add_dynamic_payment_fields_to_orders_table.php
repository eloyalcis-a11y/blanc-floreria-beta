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
            $table->string('payroll_rfc')->nullable()->after('payment_method');
            $table->string('payroll_area')->nullable()->after('payroll_rfc');
            $table->string('accounts_receivable_entity')->nullable()->after('payroll_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payroll_rfc', 'payroll_area', 'accounts_receivable_entity']);
        });
    }
};
