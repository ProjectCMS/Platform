<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_group_id')->unsigned();
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->foreign('payment_group_id')->references('id')->on('payment_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
