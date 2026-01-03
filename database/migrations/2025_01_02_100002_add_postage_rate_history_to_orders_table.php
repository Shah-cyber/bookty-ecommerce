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
            $table->foreignId('postage_rate_history_id')
                  ->nullable()
                  ->after('shipping_actual_cost')
                  ->constrained('postage_rate_history')
                  ->onDelete('set null');
            
            $table->index('postage_rate_history_id', 'idx_orders_postage_history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['postage_rate_history_id']);
            $table->dropIndex('idx_orders_postage_history');
            $table->dropColumn('postage_rate_history_id');
        });
    }
};
