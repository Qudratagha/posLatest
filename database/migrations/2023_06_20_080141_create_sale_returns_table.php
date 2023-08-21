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
        Schema::create('saleReturns', function (Blueprint $table) {
            $table->id('saleReturnID');
            $table->foreignId('saleID')->constrained('sales', 'saleID');
            $table->foreignId('customerID')->constrained('accounts', 'accountID');
            $table->integer('shippingCost')->nullable();
            $table->string('description')->nullable();
            $table->date('date');
            $table->integer('refID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saleReturns');
    }
};
