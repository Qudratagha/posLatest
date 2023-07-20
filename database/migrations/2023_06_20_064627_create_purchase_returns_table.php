<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchaseReturns', function (Blueprint $table) {
            $table->id('purchaseReturnID');
            $table->foreignId('purchaseID')->constrained('purchases', 'purchaseID');
            $table->foreignId('accountID')->constrained('accounts', 'accountID');
            $table->foreignId('supplierID')->constrained('accounts', 'accountID');
            $table->integer('amount');
            $table->integer('shippingCost');
            $table->date('date');
            $table->string('description');
            $table->integer('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('purchaseReturns');
    }
};
