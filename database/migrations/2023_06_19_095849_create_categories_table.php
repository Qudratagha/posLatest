<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('categoryID');
            $table->string('name');
            $table->string('image')->nullable();
            $table->foreignId('parentID')->nullable()->constrained('categories', 'categoryID');
            $table->tinyInteger('isActive');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
