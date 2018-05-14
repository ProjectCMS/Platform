<?php

    namespace Modules\Pages\Entities;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Page extends Model {
        use SoftDeletes;

        protected $fillable = ['parent_id', 'title', 'slug', 'order', 'content', 'seo_token', 'status_id'];
        protected $dates    = ['deleted_at'];

        public function parent ()
        {
            return $this->belongsTo('Modules\Pages\Entities\Page', 'parent_id');
        }

        public function children ()
        {
            return $this->hasMany('Modules\Pages\Entities\Page', 'parent_id', 'id');
        }

        public function seo ()
        {
            return $this->belongsTo('Modules\Seo\Entities\Seo', 'seo_token', 'seo_token');
        }

        public function status ()
        {
            return $this->belongsTo('Modules\Core\Entities\Status');
        }

        public function search (Array $data)
        {
            $pages = $this->where("parent_id", 0)->orderBy('order', 'asc');

            if(isset($data["status"])){

                if($data["status"] == 0){
                    $pages = $pages->onlyTrashed();
                }else{
                    $pages = $pages->where("status_id", $data["status"]);
                }
            }

            return $pages;
        }

    }
