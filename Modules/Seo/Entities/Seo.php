<?php

namespace Modules\Seo\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{

    use Cachable;

    protected static $logAttributes = ['seo_title', 'seo_keywords', 'seo_content'];
    protected static $logName       = 'Seo';

    protected $fillable = ['seo_token', 'seo_title', 'seo_keywords', 'seo_content'];
    protected $table    = 'seo';
}
