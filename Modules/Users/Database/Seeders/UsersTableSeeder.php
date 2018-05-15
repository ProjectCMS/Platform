<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Modules\Users\Entities\User::create([
            'name'     => 'Michel Vieira',
            'email'    => 'michelvieira@outlook.com',
            'password' => bcrypt('12345'),
        ]);
    }
}
