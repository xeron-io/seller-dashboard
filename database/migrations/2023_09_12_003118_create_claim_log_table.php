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
        Schema::create('claim_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaction')->constrained('transactions');
            $table->string('ip_address', 45);
            $table->timestamp('claimed_at')->useCurrent();
            $table->softDeletes('deleted_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_log');
    }
};
