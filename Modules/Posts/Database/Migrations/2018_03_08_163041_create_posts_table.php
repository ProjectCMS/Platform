<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePostsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('posts', function(Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->string('slug');
                $table->text('content')->nullable();
                $table->integer('author_id')->unsigned()->nullable();
                $table->integer('status_id')->unsigned()->nullable();
                $table->string('seo_token')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table('posts', function(Blueprint $table) {
                $table->foreign('author_id')->references('id')->on('admins');
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
            Schema::dropIfExists('posts');
        }
    }
