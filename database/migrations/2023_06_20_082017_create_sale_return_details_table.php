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
            $table->integer('returnQuantity');
            $table->integer('deductionAmount');
            $table->integer('subTotal');
            $table->timestamps();
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
