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
            $table->integer('code');
            $table->integer('batchNumber')->nullable();
            $table->date('expiryDate')->nullable();
            $table->integer('netUnitCost');
            $table->integer('discountValue')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('subTotal');
            $table->foreignId('saleUnit')->constrained('units', 'unitID');
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
