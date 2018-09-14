<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_subscribes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned();
            $table->integer('subscribe_id')->unsigned();
            $table->integer('votes');
        });

        Schema::table('content_subscribes', function (Blueprint $table) {
            $table->foreign('content_id')->references('id')->on('contents');
            $table->foreign('subscribe_id')->references('id')->on('subscribes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_subscribes');
    }
}
