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
        Schema::create('discrepancy_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('User who performed the count')->constrained('users');
            $table->date('count_date');
            $table->string('status')->default('Open'); // Open, In Review, Closed/Adjusted
            $table->text('general_remarks')->nullable();
            $table->timestamps(3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discrepancy_reports');
    }
};
