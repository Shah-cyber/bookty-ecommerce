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
        Schema::create('user_book_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('action', 20); // 'view', 'click', 'wishlist', 'cart', 'purchase'
            $table->decimal('weight', 3, 1)->default(1.0); // Action weight (1.0, 3.0, 4.0, 5.0)
            $table->integer('count')->default(1); // Number of times this action occurred
            $table->timestamp('last_interacted_at')->useCurrent();
            $table->timestamps();

            // Composite unique index: one row per user-book-action combination
            $table->unique(['user_id', 'book_id', 'action']);
            
            // Indexes for fast queries
            $table->index(['user_id', 'action']);
            $table->index('book_id');
            $table->index('last_interacted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_book_interactions');
    }
};
