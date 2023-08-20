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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_store')->constrained('stores');
            $table->foreignId('id_product')->constrained('product');
            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_phone');
            $table->string('ingame_id');
            $table->string('reference');
            $table->string('merchant_ref');
            $table->string('checkout_url');
            $table->string('quantity');
            $table->string('amount');
            $table->string('payment_method');
            $table->string('status');
            $table->string('review_code')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
