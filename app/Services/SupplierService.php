<?php
namespace App\Services;


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
    public function addSupplier($data){
        /*$data = array(
            'supplier_sn' => 'd123s',
            'name' => '供应商名称',
            'contacts' => '联系人',
            'mobile' => '15168668353',
            'tel' => '0571-12345645',
            'qq' => '12121',
            'website' => 'www.baidu.com',
            'address' => '杭州',
            'mark' => '备注'
        );*/
        $v = $this->supplierValidator($data);
        if(!$v['status']){
            return $v;
        }
        $data['uid'] = $this->uid;
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
        /*$data = array(
            'supplier_sn' => 'd123dsdsads',
            'name' => '供应商名称sadsad',
            'contacts' => '联系人',
            'mobile' => '15168668353',
            'tel' => '0571-12345645',
            'qq' => '12121',
            'website' => 'www.baidu.com',
            'address' => '杭州',
            'mark' => '备注'
        );*/
        $supplier = OmSupplier::where('id',$id)->first();
        if(!$supplier){
            return ['status'=>false, 'msg'=>'供应商不存在'];
        }
        $v = $this->supplierValidator($data,$id);
        if(!$v['status']){
            return $v;
        }
        $supplier = $this->model->where(array('id'=>$id,'is_deleted'=>0))->update($data);

        if($supplier){
            $supplier = $this->model->where('id',$id)->first();
            return ['status'=>true, 'data'=>$supplier];
        }else{
            return ['status'=>false, 'msg'=>'供应商更新失败'];
        }

    }

    //验证规则
    public function supplierValidator($data, $id=''){
        $message = [
            'supplier_sn.required' => '供货商编号不能为空',
            'name.required' => '供货商名称不能为空',
            'contacts.required' => '供货商联系人不能为空',
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

    //获取供应商列表
    public function getSuppliers($data){
        $query = $this->model->select('id','supplier_sn','name','contacts','sort');
        $query->where('is_deleted',0);

        if(isset($data['name']) && $data['name']){
            $query->where('name','like','%'.$data['name'].'%');
        }

        if(isset($data['supplier_sn']) && $data['supplier_sn']){
            $query->where('supplier_sn','like','%'.$data['supplier_sn'].'%');
        }
        $result['_count'] = $query->count();
        if (isset($data['offset'])) {
            $query->skip($data['offset']);
        }
        if (isset($data['limit'])) {
            $query->take($data['limit']);
        }
        $result['data'] = $query->orderBy('sort DESC')->get();

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

}