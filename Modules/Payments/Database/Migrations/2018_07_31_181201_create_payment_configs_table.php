<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_method_id')->unsigned();
            $table->string('title');
            $table->string('name');
            $table->string('value')->nullable();
            $table->text('description')->nullable();
            $table->string('type');
            $table->text('options')->nullable();
            $table->timestamps();
        });

        Schema::table('payment_configs', function (Blueprint $table) {
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_configs');
    }
}
