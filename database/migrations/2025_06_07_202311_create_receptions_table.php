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
        Schema::create('receptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('received_by_user_id');
            $table->dateTime('received_at');
            $table->enum('status', [
                'pending',
                'partial',
                'completed',
                'canceled'
            ])->default('pending');
            $table->timestamps();

            // FK a purchase_orders: sin cascada para evitar rutas múltiples
            $table->foreign('purchase_order_id')
                ->references('id')
                ->on('purchase_orders')
                ->onUpdate('no action')
                ->onDelete('no action');

            // FK a users: sin cascada (onUpdate/no action, onDelete/no action)
            $table->foreign('received_by_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('no action')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receptions');
    }
};
