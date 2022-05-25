<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->unsignedBigInteger('source_id');
            $table->foreign('source_id')->references('id')->on('users');
            $table->unsignedBigInteger('target_id');
            $table->foreign('target_id')->references('id')->on('users');
            $table->string('currency_type');
            $table->double('amount');
            $table->string('state')->default('IN_QUEUE');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
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
