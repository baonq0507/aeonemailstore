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
        Schema::table('product_users', function (Blueprint $table) {
            $table->string('order_code')->nullable();
            $table->decimal('before_balance', 10, 2)->nullable();
            $table->decimal('after_balance', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_users', function (Blueprint $table) {
            $table->dropColumn('order_code');
            $table->dropColumn('before_balance');
            $table->dropColumn('after_balance');
        });
    }
};
