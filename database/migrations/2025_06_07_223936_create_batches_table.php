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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('batch_number')->nullable(); // código del lote (puede venir del proveedor)
            $table->date('expiration_date')->nullable();
            $table->integer('quantity')->unsigned()->default(0);
            $table->timestamps();

            
            // FK a products
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('no action')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
