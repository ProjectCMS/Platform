<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_participants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->integer('content_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('votes')->default(0);
            $table->integer('votes_subscribe')->default(0);
            $table->string('image');
            $table->timestamps();
        });

        Schema::table('content_participants', function (Blueprint $table) {
            $table->foreign('content_id')->references('id')->on('contents');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_participants');
    }
}
