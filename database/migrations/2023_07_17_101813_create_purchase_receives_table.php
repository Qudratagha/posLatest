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
        Schema::create('purchaseReceives', function (Blueprint $table) {
            $table->id('purchaseReceiveID');
            $table->foreignId('purchaseID')->constrained('purchases', 'purchaseID');
            $table->foreignId('productID')->constrained('products', 'productID');
            $table->integer('orderedQty')->nullable();
            $table->integer('batchNumber')->nullable();
            $table->date('expiryDate')->nullable();
            $table->integer('receivedQty')->nullable();
            $table->integer('remainingQty')->nullable();
            $table->timestamp('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaseReceives');
    }
};
