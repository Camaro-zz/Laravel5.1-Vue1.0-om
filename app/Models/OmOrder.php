<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmOrder extends Model
{
    protected $table   = 'om_order';
    protected $guarded = ['id'];

    public function order_goods(){
        return $this->hasMany('App\Models\OmOrderGoods');
    }
}
