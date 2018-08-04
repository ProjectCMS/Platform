<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AddCountClicks extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::table('publishers', function(Blueprint $table) {
                $table->integer('count_clicks')->nullable();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down ()
        {
            Schema::table('publishers', function(Blueprint $table) {
                $table->dropColumn('count_clicks');
            });
        }
    }
