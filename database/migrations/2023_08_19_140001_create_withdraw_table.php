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
        Schema::create('withdraw', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_seller')->constrained('sellers');
            $table->string('wallet_number');
            $table->string('wallet_code');
            $table->string('wallet_name');
            $table->string('wallet_owner');
            $table->integer('amount');
            $table->string('proof')->nullable();
            $table->integer('fee');
            $table->integer('balance_before');
            $table->integer('balance_after');
            $table->string('status');
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
        Schema::dropIfExists('withdraw');
    }
};
