<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders');
            $table->foreignId('user_id')->comment('User who registered the entry')->constrained('users');
            $table->integer('quantity');
            $table->string('reason')->nullable()->after('quantity');
            $table->string('batch')->nullable(); // Batch number
            $table->date('expiration_date')->nullable();
            $table->timestamp('received_at',3);
            $table->timestamps(3);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
    }
};
