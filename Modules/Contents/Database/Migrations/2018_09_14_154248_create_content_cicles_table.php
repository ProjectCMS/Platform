<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentCiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_cicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned();
            $table->integer('subscribe_cicle_id')->unsigned();
            $table->integer('votes');
        });

        Schema::table('content_cicles', function (Blueprint $table) {
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            $table->foreign('subscribe_cicle_id')->references('id')->on('subscribe_cicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_cicles');
    }
}
