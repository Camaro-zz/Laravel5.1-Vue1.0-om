<?php
namespace App\Services;


use App\Models\OmCustomer;
use Illuminate\Support\Facades\Auth;

class CustomerService extends BaseService {

    public function __construct(OmCustomer $customer){
        $this->uid = Auth::user()->id;
        $this->model = $customer;
    }

    //添加客户
    public function addCustomer($data){
        $v = $this->CustomerValidator($data);
        if(!$v['status']){
            return $v;
        }
        $data['uid'] = $this->uid;
        $customer = $this->model->create($data);
        if($customer->id){
            return ['status'=>true, 'data'=>$customer];
        }else{
            return ['status'=>false, 'msg'=>'客户添加失败'];
        }
    }

    //编辑客户
    public function editCustomer($id, $data){
        $customer = $this->model->where('id',$id)->first();
        if(!$customer){
            return ['status'=>false, 'msg'=>'客户不存在'];
        }
        $v = $this->CustomerValidator($data,$id);
        if(!$v['status']){
            return $v;
        }
        $customer = $this->model->where(array('id'=>$id,'is_deleted'=>0))->update($data);

        if($customer){
            $customer = $this->model->where('id',$id)->first();
            return ['status'=>true, 'data'=>$customer];
        }else{
            return ['status'=>false, 'msg'=>'客户更新失败'];
        }
    }

    //获取客户详情
    public function getCustomer($id){
        $customer = $this->model->where(array('id'=>$id,'is_deleted'=>0))->first();
        if(!$customer){
            return ['status'=>false,'msg'=>'客户不存在'];
        }else{
            return ['status'=>true, 'data'=>$customer];
        }
    }

    //客户列表
    public function getCustomers($data){
        $query = $this->model->select('id','customer_sn','name','contacts','sort');
        $query->where('is_deleted',0);

        if(isset($data['name']) && $data['name']){
            $query->where('name','like','%'.$data['name'].'%');
        }

        if(isset($data['customer_sn']) && $data['customer_sn']){
            $query->where('customer_sn','like','%'.$data['customer_sn'].'%');
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

    //客户删除
    public function deleteCustomer($data){
        $ids = isset($data['ids']) ? $data['ids'] : 0;
        $del = $this->model->whereIn('id', $ids)->update('is_deleted',1);
        if(!$del){
            return ['status'=>false];
        }
        return ['status'=>true];
    }

    //验证规则
    public function CustomerValidator($data,$id=''){
        $message = [
            'customer_sn.required' => '客户编号不能为空',
            'customer_sn.unique' => '客户编号已存在',
            'contact.required' => '联系人不能为空',
            'tel.between' => '联系人电话长度必须在9-20位之间',
            'mobile.regex' => '联系人手机格式不正确',
            'tel.required' => '客户电话不能为空',
            'mobile.required' => '客户手机不能为空',
            'address.required' => '客户地址不能为空'
        ];

        $rule = [
            'customer_sn' => 'required|unique:om_customer, customer_sn,'.$id,
            'contact' => 'required',
            'tel' => 'required|between:9,20',
            'mobile' => 'required|regex:/^1[34578][0-9]{9}$/',
            'address' => 'required',
        ];

        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }
}