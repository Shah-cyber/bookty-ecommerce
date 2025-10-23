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
            $table->string('toyyibpay_bill_code')->nullable()->after('public_id');
            $table->string('toyyibpay_payment_url')->nullable()->after('toyyibpay_bill_code');
            $table->string('toyyibpay_invoice_no')->nullable()->after('toyyibpay_payment_url');
            $table->timestamp('toyyibpay_payment_date')->nullable()->after('toyyibpay_invoice_no');
            $table->string('toyyibpay_settlement_reference')->nullable()->after('toyyibpay_payment_date');
            $table->timestamp('toyyibpay_settlement_date')->nullable()->after('toyyibpay_settlement_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'toyyibpay_bill_code',
                'toyyibpay_payment_url',
                'toyyibpay_invoice_no',
                'toyyibpay_payment_date',
                'toyyibpay_settlement_reference',
                'toyyibpay_settlement_date'
            ]);
        });
    }
};
