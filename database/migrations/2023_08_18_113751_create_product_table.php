<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_category')->constrained('category')->onDelete('cascade');
            $table->foreignId('id_store')->constrained('stores')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('description');
            $table->integer('price');
            $table->string('image');
            $table->string('ingame_command');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
