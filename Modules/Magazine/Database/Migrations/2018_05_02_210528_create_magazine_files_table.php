<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagazineFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magazine_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('magazine_id')->unsigned();
            $table->string('name');
            $table->integer('order');
            $table->integer('subscriber');
            $table->timestamps();
        });

        Schema::table('magazine_files', function (Blueprint $table) {
            $table->foreign('magazine_id')->references('id')->on('magazines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('magazine_files');
    }
}
