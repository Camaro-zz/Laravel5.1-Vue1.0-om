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
    public function addCustomer(){
        $data['uid'] = $this->uid;
        $customer = $this->model->create($data);
        if($customer->id){
            $customer->customer_sn = 'B'.$customer->id;
            $customer->update();
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
        $data['email'] = $this->delSpace($data['email']);
        $v = $this->CustomerValidator($data,$id);
        if(!$v['status']){
            return $v;
        }
        if(isset($data['customer_sn']))unset($data['customer_sn']);
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
        $page = isset($data['page']) ? $data['page'] : 1;
        $limit = isset($data['limit']) ? $data['limit'] : 10;
        $offset = ($page-1)*$limit;
        $query = $this->model;
        $query->where('is_deleted',0);

        if(isset($data['name']) && $data['name']){
            $query->where('name','like','%'.$data['name'].'%');
        }

        if(isset($data['customer_sn']) && $data['customer_sn']){
            $query->where('customer_sn','like','%'.$data['customer_sn'].'%');
        }
        $result['_count'] = $query->count();
        $query->skip($offset);
        $query->take($limit);
        $result['all_page'] = ceil($result['_count'] / $limit);
        $result['data'] = $query->orderBy('sort','DESC')->get();

        return $result;
    }

    //客户删除
    public function deleteCustomer($data){
        $ids = isset($data['ids']) ? $data['ids'] : 0;
        if(!$ids){
            return ['status'=>false];
        }
        $ids = explode(',',$ids);
        $del = $this->model->whereIn('id', $ids)->delete();
        if(!$del){
            return ['status'=>false];
        }
        return ['status'=>true];
    }

    //验证规则
    public function CustomerValidator($data,$id){
        $message = [
            //'contact.required' => '联系人不能为空',
            'name.required' => '客户名称不能为空',
            'tel.between' => '联系人电话长度必须在9-20位之间',
            'mobile.regex' => '联系人手机格式不正确',
            'email.unique' => '邮箱已存在',
            //'tel.required' => '客户电话不能为空',
            //'mobile.required' => '客户手机不能为空',
            //'address.required' => '客户地址不能为空'
        ];

        $rule = [
            //'contact' => 'required',
            'name' => 'required',
            'tel' => 'between:9,20',
            'mobile' => 'regex:/^1[34578][0-9]{9}$/',
            'email' => 'unique:om_customer,email,'.$id,
            //'address' => 'required',
        ];

        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }
}