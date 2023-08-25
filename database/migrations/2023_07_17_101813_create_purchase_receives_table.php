<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchaseReceives', function (Blueprint $table) {
            $table->id('purchaseReceiveID');
            $table->foreignId('purchaseID')->constrained('purchases', 'purchaseID');
            $table->foreignId('productID')->constrained('products', 'productID');
            $table->integer('batchNumber')->nullable();
            $table->date('expiryDate')->nullable();
            $table->integer('orderedQty')->nullable();
            $table->integer('receivedQty')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('tax')->nullable();
            $table->foreignId('purchaseUnit')->constrained('units', 'unitID');
            $table->timestamp('date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchaseReceives');
    }
};
