<?php

namespace Modules\Subscribes\Entities;

use Illuminate\Database\Eloquent\Model;

class subscribeKeyLogs extends Model
{
    protected $fillable = ['key_id', 'client_id'];
}
