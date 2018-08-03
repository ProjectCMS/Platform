<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orientation_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->string('url');
            $table->string('image');
            $table->timestamps();
        });

        Schema::table('publishers', function(Blueprint $table) {
            $table->foreign('orientation_id')->references('id')->on('publisher_orientations')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publishers');
    }
}
