<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePaymentLogsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('payment_logs', function(Blueprint $table) {
                $table->increments('id');
                $table->morphs('model');
                $table->integer('method_id')->unsigned();
                $table->integer('client_id')->unsigned();
                $table->string('token_request');
                $table->text('options')->nullable();
                $table->text('message');
                $table->string('status');
                $table->timestamps();
            });

            Schema::table('payment_logs', function(Blueprint $table) {
                $table->foreign('method_id')->references('id')->on('payment_methods')->onDelete('cascade');
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
            Schema::dropIfExists('payment_logs');
        }
    }
