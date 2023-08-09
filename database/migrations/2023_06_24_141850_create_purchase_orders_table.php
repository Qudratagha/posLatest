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
        Schema::create('purchaseOrders', function (Blueprint $table) {
            $table->id('purchaseOrderID');
            $table->foreignId('purchaseID')->constrained('purchases', 'purchaseID');
            $table->foreignId('productID')->constrained('products', 'productID');
            $table->foreignId('warehouseID')->constrained('warehouses', 'warehouseID');
            $table->integer('code');
            $table->integer('quantity');
            $table->integer('batchNumber')->nullable();
            $table->date('expiryDate')->nullable();
            $table->integer('netUnitCost');
            $table->integer('discount')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('subTotal');
            $table->foreignId('purchaseUnit')->constrained('units', 'unitID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaseOrders');
    }
};
