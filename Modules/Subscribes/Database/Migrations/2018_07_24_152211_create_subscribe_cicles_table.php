<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribeCiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_cicles');
    }
}
