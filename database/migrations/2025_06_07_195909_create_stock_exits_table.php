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
        Schema::create('stock_exits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('user_id')->comment('User who registered the exit')->constrained('users');
            $table->integer('quantity');
            $table->string('type'); // e.g., Sale, Waste, Discrepancy Adjustment
            $table->text('reason')->nullable();
            $table->timestamp('exited_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_exits');
    }
};
