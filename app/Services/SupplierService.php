<?php
namespace App\Services;


use App\Models\OmGoodsMfrs;
use App\Models\OmGoodsSupplier;
use App\Models\OmSupplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierService extends BaseService {

    protected $uid;

    public function __construct(OmSupplier $omSupplier){
        $this->model = $omSupplier;
        $this->uid = Auth::user()->id;
    }


    /**添加供应商
     * @param $data
     * $data['supplier_sn']
     * $data['name']
     * $data['contacts']
     * $data['mobile']
     * $data['tel']
     * $data['qq']
     * $data['website']
     * $data['address']
     * $data['mark']
     */
    public function addSupplier(){
        $data['uid'] = $this->uid;
        $supplier = $this->model->create($data);
        if($supplier->id){
            $supplier->supplier_sn = 'G'.$supplier->id;
            $supplier->update();
            return ['status'=>true, 'data'=>$supplier];
        }else{
            return ['status'=>false, 'msg'=>'供应商添加失败'];
        }
    }

    /**
     * 编辑供应商
     * @param $id
     * @param $data
     */
    public function editSupplier($id,$data){
        $supplier = OmSupplier::where('id',$id)->first();
        if(!$supplier){
            return ['status'=>false, 'msg'=>'供应商不存在'];
        }
        $v = $this->supplierValidator($data,$id);
        if(!$v['status']){
            return $v;
        }
        if(isset($data['supplier_sn']))unset($data['supplier_sn']);
        $supplier = $this->model->where(array('id'=>$id,'is_deleted'=>0))->update($data);

        if($supplier){
            $supplier = $this->model->where('id',$id)->first();
            return ['status'=>true, 'data'=>$supplier];
        }else{
            return ['status'=>false, 'msg'=>'供应商更新失败'];
        }

    }

    //验证规则
    public function supplierValidator($data,$id=''){
        $message = [
            'name.required' => '供货商名称不能为空',
            'name.unique' => '供货商名称已存在',
            //'contacts.required' => '供货商联系人不能为空',
            //'tel.required' => '供货商电话不能为空',
            //'mobile.required' => '供货商手机不能为空',
            'tel.between' => '供货商电话长度必须在9-20位之间',
            'mobile.regex' => '供货商手机格式不正确',
        ];

        $rule = [
            'name' => 'required|unique:om_supplier,name,'.$id,
            //'contacts' => 'required',
            'tel' => 'between:9,20',
            'mobile' => 'regex:/^1[34578][0-9]{9}$/',
        ];

        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }

    //验证规则
    public function supplierGoodsValidator($data){
        $message = [
            'price.numeric' => '采购价只能为数值',
            'tax_price.numeric' => '含税采购价只能为数值',
        ];

        $rule = [
            'price' => 'numeric',
            'tax_price' => 'numeric',
        ];

        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }

    //获取供应商列表
    public function getSuppliers($data){
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = isset($data['limit']) ? $data['limit'] : 10;
        $type = isset($data['type']) ? $data['type'] : 0;
        $goods_id = isset($data['goods_id']) ? $data['goods_id'] : 0;
        $offset = ($page-1)*$limit;
        $query = $this->model->select('id','supplier_sn','name','contacts','sort','tel','mobile','qq','website','img');
        $query->where('is_deleted',0);

        if(isset($data['name']) && $data['name']){
            $query->where('name','like','%'.$data['name'].'%');
        }

        if(isset($data['supplier_sn']) && $data['supplier_sn']){
            $query->where('supplier_sn','like','%'.$data['supplier_sn'].'%');
        }
        if($goods_id > 0){
            $exist_supids = OmGoodsSupplier::where(['goods_id'=>$goods_id])->lists('supplier_id');
            $query->whereNotIn('id',$exist_supids);
        }
        $result['_count'] = $query->count();
        $result['all_page'] = ceil($result['_count'] / $limit);
        if($type == 0){
            $query->skip($offset);
            $query->take($limit);
        }
        $result['data'] = $query->orderBy('sort','DESC')->get();

        return $result;
    }

    //获取供应商详情
    public function getSupplier($id){
        $supplier = $this->model->where(array('id'=>$id,'is_deleted'=>0))->first();
        if(!$supplier){
            return ['status'=>false,'msg'=>'供应商不存在'];
        }else{
            return ['status'=>true, 'data'=>$supplier];
        }
    }

    public function deleteSupplier($ids){
        $delete = $this->model->whereIn('id',$ids)->delete();
        return ['status'=>true];
    }

    public function putSupplierSort($goods_id, $data){
        foreach ($data as $k=>$v) {
            $sup = explode('_',$v['id']);
            OmGoodsSupplier::where(array('id'=>$sup[1],'goods_id'=>$goods_id))->update(['sort'=>$v['sort']]);
        }
        $first_supplier = OmGoodsSupplier::where('goods_id',$goods_id)->orderBy('sort','DESC')->first();
        $first_supplier['name'] = OmSupplier::where('id',$first_supplier['supplier_id'])->value('name');
        return $first_supplier;
    }

    public function getSupplierGoods($id){
        $goods = OmGoodsSupplier::leftJoin('om_goods as goods', 'goods.id', '=', 'om_goods_supplier.goods_id')
                                ->leftJoin('om_goods_pack as pack', 'pack.goods_id','=','om_goods_supplier.goods_id')
                                ->select('om_goods_supplier.*','goods.cn_name','goods.en_name','goods.img','goods.product_sn','pack.num','pack.length','pack.height','pack.width','pack.gw','pack.nw')
                                ->where('goods.is_deleted',0)
                                ->where('om_goods_supplier.supplier_id',$id)
                                ->get();

        foreach ($goods as $k=>$v){
            $mfrs = OmGoodsMfrs::where(['goods_id'=>$v['goods_id'],'is_deleted'=>0])->orderBy('sort','DESC')->first();
            $goods[$k]['mfrs_sn'] = $mfrs['mfrs_sn'];
            $goods[$k]['edit'] = false;
        }
        return $goods;
    }

    public function postSupplierGoods($id, $data){
        $goods_data['product_sn'] = $data['product_sn'];
        $goods_data['cn_name'] = $data['cn_name'];
        $goods_data['en_name'] = $data['en_name'];
        $goods_data['num'] = $data['num'];
        $goods_data['length'] = $data['length'];
        $goods_data['width'] = $data['width'];
        $goods_data['height'] = $data['height'];
        $goods_data['gw'] = $data['gw'];
        $goods_data['nw'] = $data['nw'];
    }

    public function getSupplierMaxId(){
        $max_id = OmSupplier::max('id');
        if(!$max_id){
            $max_id = 0;
        }
        return $max_id+1;
    }

    public function postSupplierByGoods($goods_id, $data){
        $sup_data['name'] = isset($data['name']) ? $data['name'] : '';
        $sup_data['contacts'] = isset($data['contacts']) ? $data['contacts'] : '';
        $sup_data['tel'] = isset($data['tel']) ? $data['tel'] : '';
        $sup_data['mobile'] = isset($data['mobile']) ? $data['mobile'] : '';
        $sup_data['qq'] = isset($data['qq']) ? $data['qq'] : '';
        $sup_data['mark'] = isset($data['mark']) ? $data['mark'] : '';

        $res = $this->supplierValidator($sup_data);
        if(!$res['status']){
            return $res;
        }

        $goods_sup_data['tax_price'] = isset($data['tax_price']) ? $data['tax_price'] : 0;
        $goods_sup_data['price'] = isset($data['price']) ? $data['price'] : 0;

        $res_g = $this->supplierGoodsValidator($goods_sup_data);
        if(!$res_g['status']){
            return $res_g;
        }
        $supplier = OmSupplier::create($sup_data);
        if($supplier->id){
            $supplier->supplier_sn = 'G'.$supplier->id;
            $supplier->update();
            $goods_sup_data['goods_id'] = $goods_id;
            $goods_sup_data['supplier_id'] = $supplier->id;
            OmGoodsSupplier::create($goods_sup_data);
            return ['status'=>true, 'data'=>$supplier];
        }else{
            return ['status'=>false, 'msg'=>'供应商添加失败'];
        }
    }

}