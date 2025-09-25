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
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->after('price')->comment('Cost price at time of purchase');
            $table->decimal('total_selling', 10, 2)->nullable()->after('cost_price')->comment('Total selling amount (price × quantity)');
            $table->decimal('total_cost', 10, 2)->nullable()->after('total_selling')->comment('Total cost amount (cost_price × quantity)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['cost_price', 'total_selling', 'total_cost']);
        });
    }
};
