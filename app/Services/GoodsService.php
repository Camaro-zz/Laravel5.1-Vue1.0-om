<?php
namespace App\Services;


use App\Models\OmGoods;
use App\Models\OmGoodsCat;
use App\Models\OmGoodsImg;
use App\Models\OmGoodsMfrs;
use App\Models\OmGoodsSupplier;
use App\Models\OmSupplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GoodsService extends BaseService {

    public function __construct(){
        $this->uid = Auth::user()->id;
    }

    /**
     * 添加商品
     */
    public function addGoods($data){
        $data = array(
            'cat_id' => 1,
            'product_sn' => '12121',
            'en_name' => 'weq',
            'cn_name' => '撒打算',
            'car_types' => 'sadsadasdsds',
            'mark' => 'asdads'
        );
        $v = $this->goodsValidator($data);
        if(!$v['status']){
            return $v;
        }
        $data['uid'] = $this->uid;
        $goods = OmGoods::create($data);
        if($goods->id){
            return ['status'=>true, 'data'=>$goods];
        }else{
            return ['status'=>false, 'msg'=>'产品添加失败'];
        }
    }

    /**
     * 添加供应商关联商品
     * @param $goods_id
     * @param $data
     */
    public function addSupplierGoods($goods_id, $data){
        $goods_id = 1;
        $data = array(
            'supplier_id' => 1,
            'price' => '10.2',
            'tax' => '10.2',
            'num' => '10',
            'length' => '10.2',
            'width' => '10.2',
            'height' => '10.2',
            'gw' => '10.2',
            'nw' => '10.2',
            'mfrs_name' => 'safdsadsad',
        );

        $goods = OmGoods::where('id', $goods_id)->first();
        if(!$goods){
            return ['status'=>false, 'msg'=>'产品不存在'];
        }
        $v = $this->supplierGoodsValidator($data);
        if(!$v['status']){
            return $v;
        }
        $data['goods_id'] = $goods_id;
        $data['uid'] = $this->uid;
        $res = OmGoodsSupplier::create($data);
        if($res->id){
            return ['status'=>true, 'data'=>$res];
        }else{
            return ['status'=>false, 'msg'=>'产品添加失败'];
        }
    }

    public function editGoods($id, $data){
        $goods = OmGoods::where('id',$id)->first();
        if(!$goods){
            return ['status'=>false, 'msg'=>'产品不存在'];
        }
        $v = $this->goodsValidator($data,$id);
        if(!$v['status']){
            return $v;
        }
        $goods = OmGoods::where(array('id'=>$id,'is_deleted'=>0))->update($data);

        if($goods){
            $goods = OmGoods::where('id',$id)->first();
            return ['status'=>true, 'data'=>$goods];
        }else{
            return ['status'=>false, 'msg'=>'产品更新失败'];
        }
    }

    public function editSupplierGoods($id, $data){
        $goods = OmGoodsSupplier::where('id',$id)->first();
        if(!$goods){
            return ['status'=>false, 'msg'=>'产品不存在'];
        }
        $v = $this->supplierGoodsValidator($data,$id);
        if(!$v['status']){
            return $v;
        }
        $goods = OmGoodsSupplier::where(array('id'=>$id,'is_deleted'=>0))->update($data);

        if($goods){
            $goods = OmGoodsSupplier::where('id',$id)->first();
            return ['status'=>true, 'data'=>$goods];
        }else{
            return ['status'=>false, 'msg'=>'产品更新失败'];
        }
    }

    public function getGoods($id){
        $goods = OmGoods::where('id',$id)->first();
        if(!$goods){
            return ['status'=>false, 'msg'=>'产品不存在'];
        }
        $goods['supplier_goods'] = OmGoodsSupplier::where(array('goods_id'=>$id))->orderBy('sort','DESC')->get();
        $goods['supplier_goods_count'] = count($goods['supplier_goods']);
        if(isset($goods['supplier_goods'][0])){
            $goods['price'] = $goods['supplier_goods'][0]['price'];
            $goods['tax'] = $goods['supplier_goods'][0]['tax'];
            $goods['num'] = $goods['supplier_goods'][0]['num'];
            $goods['length'] = $goods['supplier_goods'][0]['length'];
            $goods['width'] = $goods['supplier_goods'][0]['width'];
            $goods['height'] = $goods['supplier_goods'][0]['height'];
            $goods['gw'] = $goods['supplier_goods'][0]['gw'];
            $goods['nw'] = $goods['supplier_goods'][0]['nw'];
            $goods['mfrs_name'] = $goods['supplier_goods'][0]['mfrs_name'];
        }
        return ['status'=>true,'data'=>$goods];
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
        ];

        $rule = [
            'product_sn' => 'required|unique:om_goods,product_sn,'.$id,
            'en_name' => 'required',
            'cn_name' => 'required',
        ];
        $v = Validator::make($data, $rule, $message);

        if($v->fails()){
            return ['status'=>false, 'msg' => $v->errors()];
        }else{
            return ['status'=>true];
        }
    }

    //验证规则
    public function supplierGoodsValidator($data){
        $message = [
            'price.required' => '采购价不能为空',
            'price.numeric' => '采购价只能为数值',
            'tax.required' => '税不能为空',
            'tax.numeric' => '税只能为数值',
            'num.required' => '装箱数不能为空',
            'num.integer' => '装箱数只能是整数',
            'length.numeric' => '规格长只能是数值',
            'width.numeric' => '规格宽只能是数值',
            'height.numeric' => '规格高只能是数值',
            'gw.numeric' => '毛重只能是数值',
            'nw.numeric' => '净重长只能是数值',
        ];

        $rule = [
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'num' => 'required|integer',
            'length' => 'numeric',
            'width' => 'numeric',
            'height' => 'numeric',
            'gw' => 'numeric',
            'nw' => 'numeric',
        ];

        $v = Validator::make($data, $rule, $message);

        if($v->fails()){
            return ['status'=>false, 'msg' => $v->errors()];
        }else{
            return ['status'=>true];
        }
    }
}