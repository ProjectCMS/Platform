<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubscribeLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscribe_logs', function (Blueprint $table) {
            $table->dropColumn('request_at');
            $table->integer('cicle_id')->unsigned()->after('subscribe_id');
            $table->timestamps();
        });

        Schema::table('subscribe_logs', function (Blueprint $table) {
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
        Schema::table('subscribe_logs', function (Blueprint $table) {
            $table->dateTime('request_at');
            $table->dropColumn('cicle_id');
            $table->dropTimestamps();
        });
    }
}
