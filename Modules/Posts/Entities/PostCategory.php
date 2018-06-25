<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class PostCategory extends Model {

        use Cachable;

        protected $fillable = ['category_id', 'post_id'];


        public function category ()
        {
            return $this->hasOne('Modules\Posts\Entities\Category', 'id', 'category_id');
        }

        public function post ()
        {
            return $this->belongsTo('Modules\Posts\Entities\Post', 'post_id');
        }

        public function managerItems ($post_id, $category)
        {
            $category     = collect($category);
            $postCategory = $this->where('post_id', $post_id)->pluck('category_id');

            // Delete
            if ($postCategory->diff($category)->count()) {
                foreach ($postCategory->diff($category) as $delete) {
                    $dd = $this->where('category_id', $delete);
                    $dd->forceDelete();
                }
            }
            // Insert
            if ($category->diff($postCategory)->count()) {
                foreach ($category->diff($postCategory) as $insert) {
                    $this->create([
                        'post_id'     => $post_id,
                        'category_id' => $insert
                    ]);
                }
            }
        }

    }
