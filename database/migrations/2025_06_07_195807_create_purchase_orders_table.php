<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('user_id')->comment('User who created the order')->constrained('users');
            $table->foreignId('approved_by_id')->nullable()->comment('User who approved')->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->decimal('total', 10, 2);
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'sent',
                'partial_received',
                'completed',
                'canceled'
            ])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps(3);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
