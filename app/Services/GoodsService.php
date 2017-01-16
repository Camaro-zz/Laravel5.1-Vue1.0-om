<?php
namespace App\Services;


use App\Models\OmCarType;
use App\Models\OmGoods;
use App\Models\OmGoodsCat;
use App\Models\OmGoodsImg;
use App\Models\OmGoodsMfrs;
use App\Models\OmGoodsSupplier;
use App\Models\OmSupplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GoodsService extends BaseService {

    public function __construct(){
        $this->uid = Auth::user()->id;
    }

    /**
     * 添加商品
     */
    /*public function addGoods($data){
        $v = $this->goodsValidator($data);
        if(!$v['status']){
            return $v;
        }
        $goods_data = $data;
        if(count($data['imgs']) <= 0){
            return ['status'=>false, 'msg'=>'请至少上传一张图片'];
        }
        unset($goods_data['imgs']);
        $goods_data['uid'] = $this->uid;
        $goods_data['img'] = $data['imgs'][0]['path'];
        $goods = OmGoods::create($goods_data);
        if($goods->id){
            isset($data['imgs']) && $this->setGoodsImgs($goods, $data['imgs']);
            if(isset($data['supplier_id']) && $data['supplier_id'] > 0){
                
            }
            return ['status'=>true, 'data'=>$goods];
        }else{
            return ['status'=>false, 'msg'=>'产品添加失败'];
        }
    }*/
    public function addGoods($data){
        $goods_data['product_sn'] = isset($data['product_sn']) ? $data['product_sn'] : '';
        $goods_data['en_name'] = isset($data['en_name']) ? $data['en_name'] : '';
        $goods_data['cat_id'] = isset($data['cat_id']) ? $data['cat_id'] : 0;
        $message = [
            'product_sn.required' => '产品编号不能为空',
            'product_sn.unique' => '产品编号已存在',
            'en_name.required' => '产品英文名称不能为空'
        ];
        $rule = [
            'en_name' => 'required',
            'product_sn' => 'required|unique:om_goods,product_sn',
        ];
        $res = $this->doValidate($goods_data,$rule,$message);
        if(!$res['status']){
            return $res;
        }
        $goods = OmGoods::create($goods_data);
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

    public function addGoodsMfrs($data){
        $goods_id = isset($data['goods_id']) ? intval($data['goods_id']) : 0;
        $goods = OmGoods::where('id', $goods_id)->first();
        if(!$goods){
            return ['status'=>false, 'msg'=>'产品不存在'];
        }
        $v = $this->supplierGoodsValidator($data);
        if(!$v['status']){
            return $v;
        }
        $data['uid'] = $this->uid;
        $res = OmGoodsMfrs::create($data);
        if($res->id){
            return ['status'=>true, 'data'=>$res];
        }else{
            return ['status'=>false, 'msg'=>'生产商添加失败'];
        }
    }

    public function editGoodsMfrs($id, $data){
        $mfrs = OmGoodsMfrs::where('id',$id)->first();
        if(!$mfrs){
            return ['status'=>false,'msg'=>'记录不存在'];
        }
        $goods_id = isset($data['goods_id']) ? intval($data['goods_id']) : 0;
        $goods = OmGoods::where('id', $goods_id)->first();
        if(!$goods){
            return ['status'=>false, 'msg'=>'产品不存在'];
        }
        $v = $this->supplierGoodsValidator($data);
        if(!$v['status']){
            return $v;
        }
        $res = OmGoodsMfrs::where('id',$id)->update($data);
        if($res->id){
            return ['status'=>true, 'data'=>$res];
        }else{
            return ['status'=>false, 'msg'=>'生产商更新失败'];
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
        $goods_data = $data;
        unset($goods_data['imgs']);
        unset($goods_data['real_imgs']);
        unset($goods_data['supplier_goods']);
        unset($goods_data['supplier_goods_count']);
        //dd($goods_data);
        $goods = OmGoods::where(array('id'=>$id,'is_deleted'=>0))->update($goods_data);

        if($goods){
            $goods = OmGoods::where('id',$id)->first();
            isset($data['imgs']) && $this->setGoodsImgs($goods, $data['imgs']);
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
        //dd($data);
        if($goods){
            $goods = OmGoodsSupplier::where('id',$id)->first();
            return ['status'=>true, 'data'=>$goods];
        }else{
            return ['status'=>false, 'msg'=>'产品更新失败'];
        }
    }

    public function getGoods($id){
        $goods = OmGoods::select('id','cat_id','product_sn','img','en_name','cn_name','fob_price','car_types','mark','length','num','width','height','gw','nw')->where('id',$id)->first();
        if(!$goods){
            return ['status'=>false, 'msg'=>'产品不存在'];
        }
        $goods['cat_name'] = OmGoodsCat::where('id',$goods['cat_id'])->value('name');
        //dd($goods);
        return ['status'=>true,'data'=>$goods];
    }

    public function getGoodses($data){
        //$offset = isset($data['offset']) ? $data['offset'] : 0;
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = isset($data['limit']) ? $data['limit'] : 10;
        $offset = ($page-1)*$limit;
        $query = OmGoods::leftJoin('om_goods_cat as cat','cat.id','=','om_goods.cat_id')
                        ->select('om_goods.id','om_goods.product_sn','om_goods.en_name','om_goods.cn_name','om_goods.img','om_goods.car_types','cat.name as cat_name','om_goods.fob_price')->where('om_goods.is_deleted',0);
        if(isset($data['cn_name'])){
            $query->where('om_goods.cn_name', 'like', '%' . $data['cn_name'] . '%');
        }
        if(isset($data['en_name'])){
            $query->where('om_goods.en_name', 'like', '%' . $data['en_name'] . '%');
        }
        if(isset($data['cat_id']) && $data['cat_id'] > 0){
            $query->where('om_goods.cat_id', '=', $data['cat_id']);
        }
        $result['_count'] = $query->count();
        $result['all_page'] = ceil($result['_count'] / $limit);
        $query->skip($offset);
        $query->take($limit);
        //DB::connection()->enableQueryLog();
        $result['data'] = $query->orderBy('om_goods.created_at', 'DESC')->get();
        //dump(DB::getQueryLog());
        if ($result['data']) {
            foreach ($result['data'] as &$v) {
                $v['prop'] = OmGoodsSupplier::leftJoin('om_supplier as sup','sup.id','=','om_goods_supplier.supplier_id')
                                            ->select('sup.name','sup.supplier_sn','om_goods_supplier.*')
                                            ->where(array('om_goods_supplier.goods_id'=>$v['id'],'om_goods_supplier.is_deleted'=>0))->orderBy('sort', 'DESC')->first();
                if(!$v['prop']){
                    $v['prop'] = '';
                }
                $v['mfrs'] = OmGoodsMfrs::select('mfrs_sn','mfrs_name','sort')->where(array('goods_id'=>$v['id'],'is_deleted'=>0))->orderBy('sort', 'DESC')->first();
                if(!$v['mfrs']){
                    $v['mfrs'] = '';
                }
                $v['car_type'] = OmCarType::where(array('goods_id'=>$v['id'],'is_deleted'=>0))->orderBy('sort', 'DESC')->pluck('car_type');
                if(!$v['car_type']){
                    $v['car_type'] = '';
                }
            }
        }

        return $result;
    }

    public function deleteGoodses($ids){
        $ids = explode(',',$ids);
        $delete = OmGoods::whereIn('id',$ids)->update(array('is_deleted'=>1));
        return ['status'=>true];
    }

    public function postMfrsGoods($id, $data){
        if(!isset($data['mfrs_sn']) || !$data['mfrs_sn']){
            return ['status'=>false,'msg'=>'原厂编号不能为空'];
        }
        if(!isset($data['mfrs_name']) || !$data['mfrs_name']){
            return ['status'=>false,'msg'=>'生产商名称不能为空'];
        }
        $data['goods_id'] = $id;
        $data['uid'] = $this->uid;
        $mfrs = OmGoodsMfrs::create($data);
        if($mfrs){
            return ['status'=>true, 'data'=>$mfrs];
        }else{
            return ['status'=>false,'msg'=>'生产商添加失败'];
        }
    }

    //验证规则
    public function goodsValidator($data, $id=''){
        $message = [
            'en_name.required' => '英文品名不.能为空',
            'cn_name.required' => '中文品名不能为空',
            'num.integer' => '装箱数只能是整数',
            'length.numeric' => '规格长只能是数值',
            'width.numeric' => '规格宽只能是数值',
            'height.numeric' => '规格高只能是数值',
            'gw.numeric' => '毛重只能是数值',
            'nw.numeric' => '净重长只能是数值',
        ];

        $rule = [
            'en_name' => 'required',
            'cn_name' => 'required',
            'num' => 'integer',
            'length' => 'numeric',
            'width' => 'numeric',
            'height' => 'numeric',
            'gw' => 'numeric',
            'nw' => 'numeric',
        ];
        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }

    //验证规则
    public function supplierGoodsValidator($data){
        $message = [
            'price.required' => '采购价不能为空',
            'price.numeric' => '采购价只能为数值',
            'tax.required' => '税不能为空',
            'tax.numeric' => '税只能为数值',
        ];

        $rule = [
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
        ];

        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }

    public function mfrsGoodsValidator($data){
        $message = [
            'mfrs_sn.required' => '原厂编号不能为空',
            'mfrs_name.required' => '生产商名称不能为空',
        ];

        $rule = [
            'mfrs_sn' => 'required',
            'mfrs_name' => 'required',
        ];
        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }

    protected function setGoodsImgs($goods, $imgs) {
        $goods->imgs()->delete();
        $imgsData = array();
        foreach ($imgs as $key => &$_img) {
            if($key == 0 && $_img != $goods->img){
                $goods->img = $_img;
                $goods->update();
            }
            $img_arr['img'] = $_img;
            $imgsData[] = new OmGoodsImg($img_arr);
        }
        $goods->imgs()->saveMany($imgsData);
    }

    protected  function getImgs($goods_id){
        $imgs = OmGoodsImg::where(['goods_id'=>$goods_id,'is_deleted'=>0])->lists('img');
        return $imgs;
    }

    public function getMfrsByGoods($goods_id){
        $mfrs = OmGoodsMfrs::select('id','mfrs_sn','mfrs_name','sort')->where(array('goods_id'=>intval($goods_id),'is_deleted'=>0))->orderBy('sort', 'DESC')->get();
        if(!$mfrs){
            $mfrs = '';
        }

        return $mfrs;
    }

    public function getSuppliersByGoods($goods_id){
        $suppliers = OmGoodsSupplier::leftJoin('om_supplier as sup', 'sup.id', '=', 'om_goods_supplier.supplier_id')
                                    ->select('sup.supplier_sn','sup.name','sup.contacts','sup.mobile','om_goods_supplier.*')
                                    ->where(array('om_goods_supplier.goods_id'=>$goods_id,'om_goods_supplier.is_deleted'=>0))
                                    ->orderBy('om_goods_supplier.sort', 'DESC')->get();
        if(!$suppliers){
            $suppliers = '';
        }

        return $suppliers;
    }
    public function getSupplierByGoods($id){
        $supplier = OmGoodsSupplier::where('id',$id)->select('goods_id','price','supplier_id','tax','num','length','width','height','gw','nw')->first();
        if(!$supplier || !$id){
            return ['status'=>false, 'msg'=>'参数错误'];
        }
        $goods = OmGoods::where('id',$supplier['goods_id'])->select('cn_name','en_name')->first();
        $goods_name = $goods['cn_name'].'/'.$goods['en_name'];
        return ['status'=>true, 'data'=>$supplier, 'goods_name'=>$goods_name];
    }

    public function getGoodsImgs($goods_id){
        $imgs = OmGoodsImg::where(['goods_id'=>$goods_id,'is_deleted'=>0])->lists('img');
        return $imgs;
    }

    public function postGoodsImgs($goods_id,$imgs){
        //dd($imgs);
        $goods = OmGoods::where('id',$goods_id)->first();
        isset($imgs) && count($imgs)>0 && $this->setGoodsImgs($goods, $imgs);
    }

    public function postGoodsImg($goods_id,$img){
        OmGoods::where('id',$goods_id)->update(['img'=>$img['img']]);

    }

    public function getGoodsCarTypes($goods_id){
        $car_types = OmCarType::where(['goods_id'=>$goods_id,'is_deleted'=>0])->get();
        return $car_types;
    }

    public function postGoodsCarType($car_type, $goods_id){
        if(!$goods_id){
            return ['status'=>false,'msg'=>'参数错误'];
        }
        if(!isset($car_type['brand']) || !$car_type['brand']){
            return ['status'=>false,'msg'=>'品牌不能为空'];
        }
        if(!isset($car_type['car_type']) || !$car_type['car_type']){
            return ['status'=>false,'msg'=>'车型不能为空'];
        }
        $car_type['goods_id'] = $goods_id;
        $save = OmCarType::create($car_type);
        if($save){
            return ['status'=>true,'data'=>$save];
        }else{
            return ['status'=>false,'msg'=>'添加车型出错'];
        }
    }

    public function deleteGoodsCarTypes($ids){
        $res = OmCarType::whereIn('id',$ids)->delete();
        if(!$res){
            return ['status'=>false,'msg'=>'操作失败'];
        }
        return ['status'=>true];
    }

    public function putGoodsCarType($car_type, $id){
        $res = OmCarType::where(array('id'=>$id,'is_deleted'=>0))->first();
        if(!$res){
            return ['status'=>false, 'msg'=>'车型不存在'];
        }
        if(!isset($car_type['brand']) || !$car_type['brand']){
            return ['status'=>false,'msg'=>'品牌不能为空'];
        }
        if(!isset($car_type['car_type']) || !$car_type['car_type']){
            return ['status'=>false,'msg'=>'车型不能为空'];
        }

        $car_type_id = OmCarType::where('id', $id)->update($car_type);
        if($car_type_id){
            $res = OmCarType::where('id',$car_type_id)->first();
            return ['status'=>true, 'data'=>$res];
        }else{
            return ['status'=>false, 'msg'=>'车型编辑失败'];
        }
    }
}