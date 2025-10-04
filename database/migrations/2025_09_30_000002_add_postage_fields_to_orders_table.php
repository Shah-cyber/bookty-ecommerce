<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('shipping_region', ['sm', 'sabah', 'sarawak', 'labuan'])->nullable()->after('shipping_state');
            $table->decimal('shipping_customer_price', 10, 2)->default(0)->after('shipping_region');
            $table->decimal('shipping_actual_cost', 10, 2)->default(0)->after('shipping_customer_price');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_region', 'shipping_customer_price', 'shipping_actual_cost']);
        });
    }
};


