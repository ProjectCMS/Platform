<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ////////////////////////////////////////////////
        Schema::create('subscribe_periods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('days');
        });

        ////////////////////////////////////////////////
        Schema::create('subscribe_cicles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('period_id')->unsigned();
            $table->string('title');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });

        Schema::table('subscribe_cicles', function (Blueprint $table) {
            $table->foreign('period_id')->references('id')->on('subscribe_periods');
        });

        ////////////////////////////////////////////////
        Schema::create('subscribes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('cicle_id')->unsigned();
            $table->integer('status');
            $table->string('payment_method');
            $table->dateTime('next_renovation');
            $table->timestamps();
        });

        Schema::table('subscribes', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('cicle_id')->references('id')->on('subscribe_cicles');
        });


        ////////////////////////////////////////////////
        Schema::create('subscribe_payments', function (Blueprint $table) {
            $table->increments('id');
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
        Schema::drop('subscribe_payments');
        Schema::drop('subscribes');
        Schema::drop('subscribe_cicles');
        Schema::drop('subscribe_periods');
    }
}
