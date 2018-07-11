<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'title' => '0 - 3 anos',
                'slug' => '0-3-anos',
                'image' => 'images/2018/04/engasgo.jpg',
                'created_at' => '2018-04-27 19:57:16',
                'updated_at' => '2018-06-15 12:24:42',
            ),
            1 => 
            array (
                'id' => 3,
                'parent_id' => 0,
                'title' => '3 - 6 anos',
                'slug' => '3-6-anos',
                'image' => '',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-05-14 16:47:39',
            ),
            2 => 
            array (
                'id' => 4,
                'parent_id' => 0,
                'title' => 'Dicas',
                'slug' => 'dicas',
                'image' => 'images/2018/04/bb-destro-ou-canhoto.jpg',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-06-15 11:43:14',
            ),
            3 => 
            array (
                'id' => 5,
                'parent_id' => 0,
                'title' => 'Notícias',
                'slug' => 'noticias',
                'image' => 'images/2018/04/conhecimento-11.jpg',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-06-15 11:42:42',
            ),
            4 => 
            array (
                'id' => 6,
                'parent_id' => 0,
                'title' => '6 - 12 anos',
                'slug' => '6-12-anos',
                'image' => '',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-05-14 16:47:45',
            ),
            5 => 
            array (
                'id' => 7,
                'parent_id' => 0,
                'title' => 'Revista',
                'slug' => 'revista',
                'image' => '',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-04-27 19:57:17',
            ),
            6 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'title' => 'Parceiros',
                'slug' => 'parceiros',
                'image' => '',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-04-27 19:57:17',
            ),
            7 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'title' => 'Promoções e Sorteios',
                'slug' => 'promocoes-e-sorteios',
                'image' => '',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-04-27 19:57:17',
            ),
            8 => 
            array (
                'id' => 10,
                'parent_id' => 0,
                'title' => 'Concurso',
                'slug' => 'concurso',
                'image' => '',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-04-27 19:57:17',
            ),
            9 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'title' => 'Diversos',
                'slug' => 'diversos',
                'image' => '',
                'created_at' => '2018-04-27 19:57:17',
                'updated_at' => '2018-04-27 19:57:17',
            ),
            10 => 
            array (
                'id' => 12,
                'parent_id' => 2,
                'title' => 'Teste',
                'slug' => 'teste',
                'image' => NULL,
                'created_at' => '2018-05-30 18:39:04',
                'updated_at' => '2018-05-30 18:39:04',
            ),
            11 => 
            array (
                'id' => 13,
                'parent_id' => 0,
                'title' => 'Novo Teste',
                'slug' => 'novo-teste',
                'image' => NULL,
                'created_at' => '2018-05-30 18:39:04',
                'updated_at' => '2018-05-30 18:39:04',
            ),
        ));
        
        
    }
}