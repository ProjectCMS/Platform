<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('finalized_at');
            $table->timestamps();
        });

        Schema::table('contents', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('content_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
