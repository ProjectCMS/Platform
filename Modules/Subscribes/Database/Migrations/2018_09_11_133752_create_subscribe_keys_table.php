<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateSubscribeKeysTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('subscribe_keys', function(Blueprint $table) {
                $table->increments('id');
                $table->string('key');
                $table->integer('cicle_id')->unsigned();
                $table->integer('use_general');
                $table->integer('use_client');
                $table->integer('used');
                $table->integer('status');
                $table->dateTime('validate_at');
                $table->timestamps();
            });

            Schema::table('subscribe_keys', function(Blueprint $table) {
                $table->foreign('cicle_id')->references('id')->on('subscribe_cicles')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down ()
        {
            Schema::dropIfExists('subscribe_keys');
        }
    }
