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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('saleID');
            $table->foreignId('customerID')->constrained('accounts', 'accountID');
            $table->string('saleStatus');
            $table->integer('referenceNo')->nullable();
            $table->integer('shippingCost')->nullable();
            $table->integer('discountValue')->nullable();
            $table->string('orderTax')->nullable();
            $table->string('description')->nullable();
            $table->string('orderDiscountType')->nullable();
            $table->integer('refID');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
