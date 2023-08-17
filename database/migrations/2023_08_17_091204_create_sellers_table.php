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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_membership')->default(1)->constrained('memberships')->onDelete('cascade');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique()->index();
            $table->string('phone')->unique()->index();
            $table->string('balance')->default(0);
            $table->string('password');
            $table->string('pin')->nullable();
            $table->string('access_token')->nullable();
            $table->string('verification_token')->nullable();
            $table->boolean('isVerified')->default(false);
            $table->string('forget_password_token')->nullable();
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
        Schema::dropIfExists('sellers');
    }
};
