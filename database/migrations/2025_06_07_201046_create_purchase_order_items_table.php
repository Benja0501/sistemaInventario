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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->unsigned();
            $table->decimal('unit_price', 12, 2);
            $table->timestamps();

            // FK a purchase_orders
            $table->foreign('purchase_order_id')
                ->references('id')
                ->on('purchase_orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // FK a products (cambiamos restrict por no action)
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
