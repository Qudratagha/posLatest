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
        Schema::create('salePayments', function (Blueprint $table) {
            $table->id('salePaymentID');
            $table->foreignId('saleID')->constrained('sales', 'saleID');
            $table->foreignId('accountID')->constrained('accounts', 'accountID');
            $table->integer('amount');
            $table->date('date');
            $table->string('description');
            $table->integer('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salePayments');
    }
};
