<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Posts\Entities\Tag;

    class PostTag extends Model {

        use Cachable;

        protected $fillable = ['tag_id', 'post_id'];


        public function tag ()
        {
            return $this->hasOne('Modules\Posts\Entities\Tag', 'id', 'tag_id');
        }

        public function managerItems ($post_id, $tag)
        {
            $tags    = collect($tag);
            $postTag = $this->where('post_id', $post_id)->pluck('tag_id');

            // Create tag
            foreach ($tags as $tag) {
                Tag::firstOrCreate(['title' => $tag], ['slug' => str_slug($tag, '-')]);
            }

            $tags = Tag::whereIn('title', $tags)->pluck('id');

            // Delete
            if ($postTag->diff($tags)->count()) {
                foreach ($postTag->diff($tags) as $delete) {
                    $dd = $this->where('tag_id', $delete);
                    $dd->forceDelete();
                }
            }
            // Insert
            if ($tags->diff($postTag)->count()) {
                foreach ($tags->diff($postTag) as $insert) {
                    $this->create([
                        'post_id' => $post_id,
                        'tag_id'  => $insert
                    ]);
                }
            }
        }

    }
