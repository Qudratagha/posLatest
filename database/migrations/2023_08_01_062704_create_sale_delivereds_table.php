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
        Schema::create('saleDelivered', function (Blueprint $table) {
            $table->id('saleDeliveredID');
            $table->foreignId('saleID')->constrained('sales', 'saleID');
            $table->foreignId('productID')->constrained('products', 'productID');
            $table->integer('batchNumber')->nullable();
            $table->date('expiryDate')->nullable();
            $table->integer('orderedQty')->nullable();
            $table->integer('receivedQty')->nullable();
            $table->timestamp('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saleDelivered');
    }
};
