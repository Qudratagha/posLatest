<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accountTransfers', function (Blueprint $table) {
            $table->id('accountTransferID');
            $table->foreignId('fromAccountID')->constrained('accounts', 'accountID');
            $table->foreignId('toAccountID')->constrained('accounts', 'accountID');
            $table->integer('amount');
            $table->date('date');
            $table->string('description');
            $table->integer('refID');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accountTransfers');
    }
};
