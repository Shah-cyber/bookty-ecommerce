<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postage_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('region', ['sm', 'sabah', 'sarawak'])->index();
            $table->decimal('customer_price', 10, 2);
            $table->decimal('actual_cost', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postage_rates');
    }
};


