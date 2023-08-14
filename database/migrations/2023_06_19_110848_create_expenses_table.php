<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id('expenseID');
            $table->foreignId('expenseCategoryID')->constrained('expenseCategories', 'expenseCategoryID');
            $table->foreignId('accountID')->constrained('accounts', 'accountID');
            $table->integer('amount');
            $table->date('date');
            $table->string('description')->nullable();
            $table->integer('refID');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
