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
        Schema::create('saleReturns', function (Blueprint $table) {
            $table->id('saleReturnID');
            $table->foreignId('saleID')->constrained('sales', 'saleID');
            $table->foreignId('customerID')->constrained('accounts', 'accountID');
            $table->foreignId('accountID')->constrained('accounts', 'accountID');
            $table->integer('amount');
            $table->integer('refID');
            $table->date('date');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saleReturns');
    }
};
