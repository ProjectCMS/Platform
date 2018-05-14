<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateRoleAdminsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up ()
        {
            Schema::create('role_admins', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('admin_id')->unsigned();
                $table->integer('role_id')->unsigned();
            });

            Schema::table('role_admins', function(Blueprint $table) {
                $table->foreign('admin_id')->references('id')->on('roles');
                $table->foreign('role_id')->references('id')->on('admins')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down ()
        {
            Schema::dropIfExists('role_admins');
        }
    }
