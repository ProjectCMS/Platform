<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_method');
            $table->integer('subscribe_id')->unsigned();
            $table->string('token_request');
            $table->text('message');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('subscribe_payments', function (Blueprint $table) {
            $table->foreign('subscribe_id')->references('id')->on('subscribes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_payments');
    }
}
