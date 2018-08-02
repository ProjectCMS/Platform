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
        Schema::create('subscribes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('cicle_id')->unsigned();
            $table->integer('status');
            $table->dateTime('next_renovation');
            $table->timestamps();
        });

        Schema::table('subscribes', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('cicle_id')->references('id')->on('subscribe_cicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribes');
    }
}
