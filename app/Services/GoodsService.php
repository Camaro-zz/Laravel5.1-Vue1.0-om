<?php
namespace App\Services;


use App\Models\OmGoods;
use App\Models\OmGoodsCat;
use App\Models\OmGoodsImg;
use App\Models\OmGoodsMfrs;
use App\Models\OmGoodsSupplier;
use App\Models\OmSupplier;

class GoodsService extends BaseService {

    public function __construct(OmGoods $omGoods,OmGoodsCat $omGoodsCat, OmSupplier $omSupplier, OmGoodsSupplier $omGoodsSupplier, OmGoodsImg $omGoodsImg, OmGoodsMfrs $omGoodsMfrs){
    }

    /**
     * 添加商品
     */
    public function addGoods($data){

    }

    public function editGoods($id, $data){

    }

    public function getGoods($id){

    }

    public function getGoodses($data){

    }

    public function deleteGoodses($ids){

    }

}