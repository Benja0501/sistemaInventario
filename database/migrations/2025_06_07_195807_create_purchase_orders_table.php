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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('created_by_user_id');
            $table->unsignedBigInteger('supplier_id');
            $table->dateTime('order_date')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'sent',
                'partial_received',
                'completed',
                'canceled'
            ])->default('pending');
            $table->timestamps();

            //referencias
            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('no action');

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onUpdate('cascade')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
