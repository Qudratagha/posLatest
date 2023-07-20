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
        Schema::create('purchases', function (Blueprint $table) {
            $table->integer('purchaseID');
            $table->foreignId('supplierID')->constrained('accounts', 'accountID');
            $table->foreignId('purchaseStatusID')->constrained('purchaseStatuses', 'purchaseStatusID');
            $table->string('image')->nullable();
            $table->integer('orderTax')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('shippingCost')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
