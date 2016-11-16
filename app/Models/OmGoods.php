<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmGoods extends Model
{
    protected $table   = 'om_goods';

    protected $guarded = ['id'];

    public function imgs(){
        return $this->hasMany('App\Models\OmGoodsImg', 'goods_id', 'id');
    }
}
