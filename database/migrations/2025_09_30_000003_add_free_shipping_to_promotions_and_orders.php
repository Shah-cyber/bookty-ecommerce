<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flash_sales', function (Blueprint $table) {
            $table->boolean('free_shipping')->default(false)->after('discount_value');
        });
        Schema::table('book_discounts', function (Blueprint $table) {
            $table->boolean('free_shipping')->default(false)->after('description');
        });
        Schema::table('coupons', function (Blueprint $table) {
            $table->boolean('free_shipping')->default(false)->after('discount_value');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_free_shipping')->default(false)->after('shipping_actual_cost');
        });
    }

    public function down(): void
    {
        Schema::table('flash_sales', function (Blueprint $table) {
            $table->dropColumn('free_shipping');
        });
        Schema::table('book_discounts', function (Blueprint $table) {
            $table->dropColumn('free_shipping');
        });
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('free_shipping');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_free_shipping');
        });
    }
};


