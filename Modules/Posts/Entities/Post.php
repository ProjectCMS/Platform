<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Core\Traits\FormatDates;

    class Post extends Model {

        use SoftDeletes;
        use FormatDates;
        use Cachable;

        protected static $logAttributes = ['title', 'content'];
        protected static $logName       = 'Posts';

        protected $fillable = [
            'title',
            'slug',
            'content',
            'author_id',
            'status_id',
            'seo_token',
            'created_at',
            'updated_at'
        ];

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

        public function seo ()
        {
            return $this->belongsTo('Modules\Seo\Entities\Seo', 'seo_token', 'seo_token');
        }

        public function status ()
        {
            return $this->belongsTo('Modules\Core\Entities\Status');
        }

        public function author ()
        {
            return $this->belongsTo('Modules\Users\Entities\User');
        }

        public function categories ()
        {
            return $this->belongsToMany('Modules\Posts\Entities\Category', 'post_categories');
        }

        public function tags ()
        {
            return $this->belongsToMany('Modules\Posts\Entities\Tag', 'post_tags');
        }

        public function images ()
        {
            return $this->hasMany('Modules\Posts\Entities\PostImage')->orderBy('order');
        }

        public function dates ()
        {
            $dates = $this->select(\DB::raw('DATE_FORMAT(updated_at, "%Y-%m") as date'))
                          ->groupBy('date')
                          ->orderBy('date', 'DESC')
                          ->pluck('date', 'date')
                          ->map(function($model) {
                              return \Date::parse($model)->format("F Y");
                          });

            return $dates;
        }

        public function search (Array $request)
        {
            $posts = $this->with(['status', 'author', 'categories', 'tags'])
                          ->when($request, function($query) use ($request) {

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
                                      case 'author':
                                          $query->whereHas('author', function($query) use ($request) {
                                              $query->orderBy('name', $request["order"]);
                                          });
                                          break;
                                      default:
                                          $query->orderBy($request["sort"], $request["order"]);
                                          break;
                                  }
                              } else {
                                  $query->orderBy('updated_at', 'DESC');
                              }

                              if (isset($request["author"]) && $request["author"] != NULL) {
                                  $query->whereHas('author', function($query) use ($request) {
                                      $query->where('name', $request["author"]);
                                  });
                              }

                              if (isset($request["category_title"]) && $request["category_title"] != NULL) {
                                  $query->whereHas('categories', function($query) use ($request) {
                                      $query->where('categories.title', $request["category_title"]);
                                  });
                              }

                              if (isset($request["category_id"]) && $request["category_id"] != NULL) {
                                  $query->whereHas('categories', function($query) use ($request) {
                                      $query->where('categories.id', $request["category_id"]);
                                  });
                              }

                              if (isset($request["tag_title"]) && $request["tag_title"] != NULL) {
                                  $query->whereHas('tags', function($query) use ($request) {
                                      $query->where('tags.title', $request["tag_title"]);
                                  });
                              }

                              if (isset($request["date"]) && $request["date"] != NULL) {
                                  $date = \Carbon\Carbon::parse($request["date"]);
                                  $query->whereYear("updated_at", $date->format('Y'));
                                  $query->whereMonth("updated_at", $date->format('m'));
                              }

                              if (isset($request["search"]) && $request["search"] != NULL) {
                                  $query->where('title', 'like', '%' . $request["search"] . '%');
                              }

                          }, function($query) {
                              $query->orderBy('updated_at', 'DESC');
                          });

            return $posts;
        }

    }
