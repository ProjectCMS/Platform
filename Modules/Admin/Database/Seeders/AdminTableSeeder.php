<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Modules\Admin\Entities\Admin::create([
            'name'     => 'Michel Vieira',
            'email'    => 'michelvieira@outlook.com',
            'password' => bcrypt('12345'),
        ]);
    }
}
