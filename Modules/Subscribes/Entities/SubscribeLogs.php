<?php

namespace Modules\Subscribes\Entities;

use Illuminate\Database\Eloquent\Model;

class SubscribeLogs extends Model
{
    protected $fillable = ['subscribe_id', 'cicle_id', 'validate_at'];
}
