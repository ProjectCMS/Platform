<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateSubscribeKeyLogsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('subscribe_key_logs', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('key_id')->unsigned();
                $table->integer('client_id')->unsigned();
                $table->timestamps();
            });

            Schema::table('subscribe_key_logs', function(Blueprint $table) {
                $table->foreign('key_id')->references('id')->on('subscribe_keys')->onDelete('cascade');
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down ()
        {
            Schema::dropIfExists('subscribe_key_logs');
        }
    }
