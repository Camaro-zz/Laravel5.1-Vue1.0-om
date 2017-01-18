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
        $data['supplier_sn'] = $this->makeSn(2);
        $supplier = $this->model->create($data);
        if($supplier->id){
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
        $v = $this->supplierValidator($data);
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
    public function supplierValidator($data){
        $message = [
            'name.required' => '供货商名称不能为空',
            'contacts.required' => '供货商联系人不能为空',
            'tel.required' => '供货商电话不能为空',
            'mobile.required' => '供货商手机不能为空',
            'tel.between' => '供货商电话长度必须在9-20位之间',
            'mobile.regex' => '供货商手机格式不正确',
            'address.required' => '供货商地址不能为空'
        ];

        $rule = [
            'name' => 'required',
            'contacts' => 'required',
            'tel' => 'required|between:9,20',
            'mobile' => 'required|regex:/^1[34578][0-9]{9}$/',
            'address' => 'required',
        ];

        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }

    //获取供应商列表
    public function getSuppliers($data){
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = isset($data['limit']) ? $data['limit'] : 10;
        $offset = ($page-1)*$limit;
        $query = $this->model->select('id','supplier_sn','name','contacts','sort','tel','mobile','qq','website','img');
        $query->where('is_deleted',0);

        if(isset($data['name']) && $data['name']){
            $query->where('name','like','%'.$data['name'].'%');
        }

        if(isset($data['supplier_sn']) && $data['supplier_sn']){
            $query->where('supplier_sn','like','%'.$data['supplier_sn'].'%');
        }
        $result['_count'] = $query->count();
        $result['all_page'] = ceil($result['_count'] / $limit);
        $query->skip($offset);
        $query->take($limit);
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
        $delete = $this->model->whereIn('id',$ids)->update(array('is_deleted'=>1));
        return ['status'=>true];
    }

    public function putSupplierSort($goods_id, $data){
        foreach ($data as $k=>$v) {
            $sup = explode('_',$v['id']);
            OmGoodsSupplier::where(array('id'=>$sup[1],'goods_id'=>$goods_id))->update(['sort'=>$v['sort']]);
        }
    }

    public function getSupplierGoods($id){
        $goods = OmGoodsSupplier::leftJoin('om_goods as goods', 'goods.id', '=', 'om_goods_supplier.goods_id')
                                ->select('om_goods_supplier.*','goods.cn_name','goods.en_name','goods.img','goods.product_sn','goods.num','goods.length','goods.height','goods.width','goods.gw','goods.nw')
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

}