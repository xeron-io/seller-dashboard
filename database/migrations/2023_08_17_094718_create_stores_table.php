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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_seller')->constrained('sellers')->onDelete('cascade');
            $table->foreignId('id_theme')->constrained('themes')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->string('domain');
            $table->string('youtube');
            $table->string('instagram');
            $table->string('tiktok');
            $table->string('facebook');
            $table->string('phone');
            $table->string('discord');
            $table->string('status');
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
