<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('productID');
            $table->string('name');
            $table->integer('code');
            $table->foreignId('brandID')->constrained('brands', 'brandID');
            $table->foreignId('categoryID')->constrained('categories', 'categoryID');
            $table->tinyInteger('isExpire');
            $table->integer('productUnit');
            $table->integer('purchasePrice');
            $table->integer('salePrice');
            $table->integer('wholeSalePrice');
            $table->integer('alertQuantity');
            $table->string('description');
            $table->string('image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
