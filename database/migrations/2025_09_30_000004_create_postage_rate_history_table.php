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
        Schema::create('postage_rate_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postage_rate_id')
                  ->constrained('postage_rates')
                  ->onDelete('cascade');
            $table->decimal('customer_price', 10, 2);
            $table->decimal('actual_cost', 10, 2);
            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->text('comment')->nullable();
            $table->timestamp('valid_from');
            $table->timestamp('valid_until')->nullable();
            $table->timestamp('created_at');
            
            // Indexes for performance
            $table->index(['postage_rate_id', 'valid_from', 'valid_until'], 'idx_rate_validity');
            $table->index('valid_until', 'idx_valid_until');
            $table->index('created_at', 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postage_rate_history');
    }
};
