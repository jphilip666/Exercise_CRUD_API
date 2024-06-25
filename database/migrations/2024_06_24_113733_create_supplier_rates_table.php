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
        Schema::create('supplier_rates', function (Blueprint $table) {
            $table->id('supplier_rate_id');
            $table->foreignId('supplier_id');
            $table->decimal('currency', total: 10, places: 2);
            $table->date('rate_start_date');
            $table->date('rate_end_date')->nullable();
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_rates');
    }
};
