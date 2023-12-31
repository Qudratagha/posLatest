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
        Schema::create('saleOrders', function (Blueprint $table) {
            $table->id('saleOrderID');
            $table->foreignId('saleID')->constrained('sales', 'saleID');
            $table->foreignId('productID')->constrained('products', 'productID');
            $table->foreignId('warehouseID')->constrained('warehouses', 'warehouseID');
            $table->integer('quantity');
            $table->integer('batchNumber');
            $table->date('expiryDate');
            $table->integer('netUnitCost');
            $table->integer('discountValue');
            $table->integer('tax');
            $table->integer('subTotal');
            $table->integer('saleUnit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saleOrders');
    }
};
