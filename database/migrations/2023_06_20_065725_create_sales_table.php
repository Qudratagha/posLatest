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
            $table->foreignId('accountID')->constrained('accounts', 'accountID');
            $table->string('orderTax');
            $table->string('orderDiscountType');
            $table->integer('discountValue');
            $table->integer('shippingCost');
            $table->string('description');
            $table->date('date');
            $table->integer('refID');
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
