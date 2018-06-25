<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateMenuItemsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('menu_items', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('menu_id')->unsigned();
                $table->integer('parent_id');
                $table->integer('tmp_id');
                $table->string('title');
                $table->string('icon')->nullable();
                $table->string('url')->nullable();
                $table->string('provider_model')->nullable();
                $table->integer('provider_id')->nullable();
                $table->integer('order')->nullable();
                $table->timestamps();
            });

            Schema::table('menu_items', function(Blueprint $table) {
                $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down ()
        {
            Schema::dropIfExists('menu_items');
        }
    }
