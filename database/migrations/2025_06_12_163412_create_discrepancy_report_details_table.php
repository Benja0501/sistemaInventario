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
        Schema::create('discrepancy_report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discrepancy_report_id')->constrained('discrepancy_reports')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('system_quantity');
            $table->integer('physical_quantity');
            $table->integer('difference');
            $table->text('justification')->nullable();
            $table->timestamps(3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discrepancy_report_details');
    }
};
