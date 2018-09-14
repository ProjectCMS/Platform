<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class UpdateMenuItems extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::table('menu_items', function(Blueprint $table) {
                $table->renameColumn('provider_model', 'model_type');
                $table->renameColumn('provider_id', 'model_id');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down ()
        {
            Schema::table('menu_items', function(Blueprint $table) {
                $table->renameColumn('model_type', 'provider_model');
                $table->renameColumn('model_id', 'provider_id');
            });
        }
    }
