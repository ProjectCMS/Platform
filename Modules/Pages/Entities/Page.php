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

        protected $fillable = ['parent_id', 'title', 'slug', 'order', 'content', 'seo_token', 'status_id'];
        protected $dates    = ['deleted_at'];

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

        public function seo ()
        {
            return $this->belongsTo('Modules\Seo\Entities\Seo', 'seo_token', 'seo_token');
        }

        public function menuItem ()
        {
            return $this->belongsTo('Modules\Menus\Entities\MenuItem', 'id', 'provider_id')->where(function ($query) {
                return $query->whereProviderModel('\Modules\Pages\Entities\Page');
            });
        }

        public function status ()
        {
            return $this->belongsTo('Modules\Core\Entities\Status');
        }

        public function search (Array $request)
        {
            $pages = $this->with(['parent', 'children'])->when($request, function($query) use ($request) {

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

