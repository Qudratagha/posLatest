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
        Schema::create('purchaseReturnPayments', function (Blueprint $table) {
            $table->id('purchaseReturnPaymentID');
            $table->foreignId('purchaseReturnID')->constrained('purchaseReturns', 'purchaseReturnID');
            $table->foreignId('accountID')->constrained('accounts', 'accountID');
            $table->integer('amount');
            $table->string('description')->nullable();
            $table->integer('refID');
            $table->date('date');
           });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaseReturnPayments');
    }
};
