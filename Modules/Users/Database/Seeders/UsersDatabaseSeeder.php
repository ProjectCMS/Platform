<?php

    namespace Modules\Users\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Database\Eloquent\Model;

    class UsersDatabaseSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run ()
        {
            Model::unguard();
            $this->call(PermissionsTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(ConnectRelationshipsSeeder::class);
            //        $this->call(UsersTableSeeder::class);
        }
    }
