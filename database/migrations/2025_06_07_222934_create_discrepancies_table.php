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
        Schema::create('discrepancies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('system_quantity')->unsigned();
            $table->integer('physical_quantity')->unsigned();
            $table->enum('discrepancy_type', [
                'missing',
                'surplus',
                'damaged',
                'wrong_location',
                'other'
            ]);
            $table->text('note')->nullable();
            $table->string('evidence_path')->nullable();
            $table->unsignedBigInteger('reported_by_user_id')->nullable();
            $table->dateTime('reported_at')->useCurrent();
            $table->timestamps();

            // FK a products: sin cascada
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('no action')
                ->onDelete('no action');

            // FK a users (reported_by_user_id): sin cascada
            $table->foreign('reported_by_user_id')
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
        Schema::dropIfExists('discrepancies');
    }
};
