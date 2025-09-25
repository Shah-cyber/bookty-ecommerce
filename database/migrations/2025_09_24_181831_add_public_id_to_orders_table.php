<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'public_id')) {
                $table->string('public_id', 32)->nullable()->unique()->after('id');
            }
        });

        // Backfill existing rows with a random unique id
        $orders = DB::table('orders')->whereNull('public_id')->select('id')->get();
        foreach ($orders as $order) {
            $unique = $this->generateId();
            // Ensure uniqueness
            while (DB::table('orders')->where('public_id', $unique)->exists()) {
                $unique = $this->generateId();
            }
            DB::table('orders')->where('id', $order->id)->update(['public_id' => $unique]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'public_id')) {
                $table->dropUnique(['public_id']);
                $table->dropColumn('public_id');
            }
        });
    }

    private function generateId(): string
    {
        // 12-char base36 upper-case token
        return strtoupper(substr(bin2hex(random_bytes(8)), 0, 12));
    }
};
