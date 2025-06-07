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
        Schema::create('reception_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reception_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity_received')->unsigned();
            $table->integer('quantity_missing')->unsigned()->default(0);
            $table->integer('quantity_damaged')->unsigned()->default(0);
            $table->timestamps();

            // FK a receptions: sin cascada
            $table->foreign('reception_id')
                ->references('id')
                ->on('receptions')
                ->onUpdate('no action')
                ->onDelete('no action');

            // FK a products: sin cascada
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('no action')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reception_items');
    }
};
