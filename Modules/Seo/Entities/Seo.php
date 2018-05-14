<?php

namespace Modules\Seo\Entities;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = ['seo_token', 'seo_title', 'seo_keywords', 'seo_content'];
    protected $table    = 'seo';
}
