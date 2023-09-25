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
        Schema::table('two_factor_authentications', function (Blueprint $table) {
            // after google2fa_secret add ip_address and user_agent
            $table->string('ip_address')->nullable()->after('google2fa_secret');
            $table->longText('user_agent')->nullable()->after('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('two_factor_authentications', function (Blueprint $table) {
            //
        });
    }
};
