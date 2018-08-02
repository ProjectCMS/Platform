<?php

namespace Modules\Payments\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\FormatDates;

class PaymentMethod extends Model
{

    use FormatDates;

    protected $fillable = ['status'];

    public function configs(){
        return $this->hasMany('Modules\Payments\Entities\PaymentConfig');
    }

    public function group(){
        return $this->belongsTo('Modules\Payments\Entities\PaymentGroup');
    }

}
