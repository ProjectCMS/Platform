<?php

namespace Modules\Core\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use Cachable;

    protected $fillable = [];
    protected $table    = 'status';
}
