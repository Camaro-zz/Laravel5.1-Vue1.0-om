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

    //验证规则
    public function goodsValidator($data, $id=''){
        $message = [
            'product_sn.required' => '产品编号不能为空',
            'en_name.required' => '英文品名不能为空',
            'cn_name.required' => '中文品名不能为空',
            'tel.required' => '供货商电话不能为空',
            'mobile.required' => '供货商手机不能为空',
            'supplier_sn.unique' => '供货商编号已存在',
            'tel.between' => '供货商电话长度必须在9-20位之间',
            'mobile.regex' => '供货商手机格式不正确',
            'address.required' => '供货商地址不能为空'
        ];

        $rule = [
            'supplier_sn' => 'required|unique:om_supplier,supplier_sn,'.$id,
            'name' => 'required',
            'contacts' => 'required',
            'tel' => 'required|between:9,20',
            'mobile' => 'required|regex:/^1[34578][0-9]{9}$/',
            'address' => 'required',
        ];

        $v = Validator::make($data, $rule, $message);

        if($v->fails()){
            return ['status'=>false, 'msg' => $v->errors()];
        }else{
            return ['status'=>true];
        }
    }
}