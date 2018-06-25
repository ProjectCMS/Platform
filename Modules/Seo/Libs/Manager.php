<?php

    namespace Modules\Seo\Libs;

    use Modules\Posts\Entities\Post;
    use SEOMeta;
    use OpenGraph;
    use Twitter;
    use SEO;

    class Manager {

        public function setData ($type = NULL, $model = NULL, $custom = [])
        {

            // Default
            $title       = setting('site_name');
            $description = setting('site_description');
            $url         = url()->current();
            $keywords    = explode(', ', setting('site_keywords'));

            if ($custom) {
                $custom = (object)$custom;
            }

            switch ($type) {
                case 'post':
                    $prev = Post::where('id', '<', $model->id)->orderBy('id', 'desc')->first();
                    $next = Post::where('id', '>', $model->id)->first();

                    $title       = $model->seo->seo_title . ' - ' . $title;
                    $description = $model->seo->seo_content;
                    $url         = route('web.posts.' . $model->slug);
                    $keywords    = explode(', ', $model->seo->seo_keywords);

                    if ($prev) {
                        SEOMeta::setPrev(route('web.posts.' . $prev->slug));
                    }
                    if ($next) {
                        SEOMeta::setNext(route('web.posts.' . $next->slug));
                    }

                    SEOMeta::addMeta('article:published_time', $model->created_at->toW3CString(), 'property');

                    OpenGraph::addProperty('type', 'article');
                    OpenGraph::setTitle($title)
                             ->setDescription($model->seo->seo_content)
                             ->setType('article')
                             ->setArticle([
                                 'published_time'  => $model->created_at,
                                 'modified_time'   => $model->updated_at,
                                 'expiration_time' => $model->deleted_at,
                                 'author'          => $model->author->name,
                             ]);

                    if ($model->images->count()) {
                        OpenGraph::addImage([
                            'url'  => asset('storage/' . $model->images->first()->path),
                            'size' => 300
                        ]);
                    }

                    break;

                case 'category':
                    $title = $model->title . ' - ' . $title;
                    if ($model->image != NULL) {
                        OpenGraph::addImage([
                            'url'  => asset('storage/' . $model->image),
                            'size' => 300
                        ]);
                    }
                    break;

                case 'tag':
                    $title = $model->title . ' - ' . $title;
                    break;

                case 'page':
                    if ($model != NULL) {
                        $title       = $model->seo->seo_title . ' - ' . $title;
                        $description = $model->seo->seo_content;
                        $url         = route('web.pages.' . $model->slug);
                        $keywords    = explode(', ', $model->seo->seo_keywords);
                    }
                    if ($custom) {
                        $title = $custom->title . ' - ' . $title;
                    }
                    break;

                default:
                    break;
            }


            SEOMeta::addKeyword($keywords);
            SEOMeta::setTitle($title);
            SEOMeta::setDescription($description);
            SEOMeta::setCanonical($url);

            OpenGraph::setUrl($url);
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::setSiteName(setting('site_name'));
        }

    }