<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class RemoveSeoToken extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::table('seo', function(Blueprint $table) {
                $table->dropColumn('seo_token');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down ()
        {
            Schema::table('seo', function(Blueprint $table) {
                $table->string('seo_token');
            });
        }
    }
