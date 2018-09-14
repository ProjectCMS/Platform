<?php

    namespace Modules\Seo\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class Seo extends Model {

        use Cachable;

        protected static $logAttributes = ['seo_title', 'seo_keywords', 'seo_content'];
        protected static $logName       = 'Seo';

        protected $fillable = ['model_type', 'model_id', 'seo_title', 'seo_keywords', 'seo_content'];
        protected $table    = 'seo';


        public function model ()
        {
            return $this->morphTo();
        }

        public function createPolymorphic ($request, $model, $id)
        {
            $this->updateOrCreate([
                'model_type' => $model,
                'model_id'   => $id,
            ], [
                'seo_title'    => $request->seo_title ? $request->seo_title : $request->title,
                'seo_keywords' => $request->seo_keywords,
                'seo_content'  => $request->seo_content,
            ]);
        }

    }
