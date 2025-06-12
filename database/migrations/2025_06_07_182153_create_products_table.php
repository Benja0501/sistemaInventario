<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->integer('stock')->default(0);
            $table->integer('minimum_stock')->default(10);
            // Precio de referencia para estimar valor y facilitar nuevas compras.
            $table->decimal('purchase_price', 10, 2)->nullable(); 
            // El precio al que el producto se vende al cliente final.
            $table->decimal('sale_price', 10, 2)->default(0); 
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
