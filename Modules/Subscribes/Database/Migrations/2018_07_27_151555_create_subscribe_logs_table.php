<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscribe_id')->unsigned();
            $table->dateTime('request_at');
            $table->dateTime('validate_at');
        });

        Schema::table('subscribe_logs', function (Blueprint $table) {
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
        Schema::dropIfExists('subscribes_logs');
    }
}
