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
        Schema::create('saleReturnDetails', function (Blueprint $table) {
            $table->id('saleReturnDetailID');
            $table->foreignId('saleReturnID')->constrained('saleReturns', 'saleReturnID');
            $table->foreignId('productID')->constrained('products', 'productID');
            $table->integer('batchNumber');
            $table->integer('returnQuantity');
            $table->date('expiryDate')->nullable();
            $table->integer('deductionAmount')->nullable();
            $table->integer('subTotal');
            $table->string('description')->nullable();
            $table->integer('refID');
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saleReturnDetails');
    }
};
