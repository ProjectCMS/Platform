<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePagesTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('pages', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id');
                $table->string('title');
                $table->string('slug');
                $table->text('content');
                $table->integer('order')->nullable();
                $table->string('seo_token');
                $table->integer('status_id')->unsigned();
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::table('pages', function(Blueprint $table) {
                $table->foreign('status_id')->references('id')->on('status');
            });

        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down ()
        {
            Schema::dropIfExists('pages');
        }
    }
