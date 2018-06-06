<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateMenuLocationsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('menu_locations', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('menu_id')->unsigned();
                $table->string('location');
            });

            Schema::table('menu_locations', function(Blueprint $table) {
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
            Schema::dropIfExists('menu_locations');
        }
    }
