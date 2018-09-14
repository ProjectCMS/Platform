<?php

    namespace Modules\Pages\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Core\Traits\FormatDates;

    class Page extends Model {

        use SoftDeletes;
        use FormatDates;
        use Cachable;

        protected static $logAttributes = ['title', 'content'];
        protected static $logName       = 'Páginas';

        protected $fillable = [
            'parent_id',
            'title',
            'slug',
            'order',
            'content',
            'status_id',
            'template_id'
        ];
        protected $appends  = ['model_type'];
        protected $dates    = ['deleted_at'];

        public function getModelTypeAttribute ()
        {
            return 'pages';
        }

        public function setTitleAttribute ($value)
        {
            $this->attributes["title"] = $value;
            $this->attributes["slug"]  = str_slug($value, '-');
        }

        public function setContentAttribute ($value)
        {
            $content = preg_replace("/<p[^>]*?>/", "", $value);
            $content = str_replace("</p>", "\r\n", $content);

            $this->attributes["content"] = $content;
        }

        public function parent ()
        {
            return $this->belongsTo('Modules\Pages\Entities\Page', 'parent_id')
                        ->withDefault(['title' => 'Página principal']);
        }

        public function children ()
        {
            return $this->hasMany('Modules\Pages\Entities\Page', 'parent_id', 'id');
        }

        public function template ()
        {
            return $this->belongsTo('Modules\Pages\Entities\PageTemplate');
        }

        public function seo ()
        {
            return $this->morphOne('Modules\Seo\Entities\Seo', 'model');
        }

        public function menu_item ()
        {
            return $this->morphMany('Modules\Menus\Entities\MenuItem', 'model');
        }

        public function status ()
        {
            return $this->belongsTo('Modules\Core\Entities\Status');
        }

        public function search (Array $request)
        {
            $pages = $this->with(['seo', 'parent', 'children'])->when($request, function($query) use ($request) {

                if (isset($request["status"]) && $request["status"] != NULL) {
                    switch ($request["status"]) {
                        case 0:
                            $query->onlyTrashed();
                            break;
                        default:
                            $query->where("status_id", $request["status"]);
                            break;
                    }
                }
                if (isset($request["sort"]) && $request["sort"] != NULL) {
                    switch ($request["sort"]) {
                        default:
                            $query->orderBy($request["sort"], $request["order"]);
                            break;
                    }
                } else {
                    $query->orderBy('order', 'asc');
                }

                if (isset($request["parent"]) && $request["parent"] != NULL) {
                    $query->where('parent_id', $request["parent"]);
                }

            }, function($query) {
                $query->orderBy('order', 'asc');
            });

            return $pages;
        }

    }

