<?php
namespace App\Services;


use App\Models\OmCarType;
use App\Models\OmCustomer;
use App\Models\OmGoods;
use App\Models\OmGoodsMfrs;
use App\Models\OmGoodsSupplier;
use App\Models\OmOrder;
use App\Models\OmOrderGoods;
use App\Models\OmSupplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService {
    public function __construct(){
        $this->uid = Auth::user()->id;
    }

    //添加订单
    public function addOrder($customer_id,$data){
        $save_data['uid'] = $this->uid;
        $save_data['customer_id'] = $customer_id;
        $save_data['contract_sn'] = $data['contract_sn'];
        $save_data['price'] = $data['price'];
        $save_data['mark'] = $data['mark'];
        $order = OmOrder::create($save_data);
        if($order->id){
            return ['status'=>true, 'data'=>$order];
        }else{
            return ['status'=>false, 'msg'=>'订单添加失败'];
        }
    }

    public function setOrderGoods($order, $order_goods){
        foreach ($order_goods as $k=>$v){
            $v['order_id'] = $order['id'];
            $v['customer_id'] = $order['customer_id'];
            if(!isset($v['id']) || !$v['id']){
                OmOrderGoods::create($order_goods);
            }else{
                OmOrderGoods::where('id',$v['id'])->update($order_goods);
            }
        }
    }

    //编辑订单
    public function editOrder($id,$data){
        $order = OmOrder::where('id',$id)->first();
        if(!$order){
            return ['status'=>false, 'msg'=>'订单不存在'];
        }
        $update_data['price'] = $data['price'];
        $update_data['mark'] = $data['mark'];
        $order_id = OmOrder::where('id',$id)->update($update_data);
        if($order_id){
            return ['status'=>true, 'data'=>$order];
        }else{
            return ['status'=>false, 'msg'=>'订单更新失败'];
        }
    }

    //获取订单
    public function getOrder($id){
        $order = OmOrder::where('id',$id)->first();
        if(!$order){
            return ['status'=>false,'msg'=>'订单不存在'];
        }
        $order['order_goods'] = OmOrderGoods::select('om_order_goods.goods_id','om_order_goods.fob_price','om_order_goods.num','om_goods.en_name','om_goods.cn_name','om_goods.product_sn','om_goods.img')
                                            ->leftJoin('om_goods','om_goods.id','=','om_order_goods.goods_id')
                                            ->where(array('om_order_goods.order'=>$id,'om_order_goods.is_deleted'=>0))->get();

        return $order;
    }

    //获取订单列表
    public function getOrders($data){
        $offset = isset($params['offset']) ? $params['offset'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 10;
        $query = OmOrder::leftJoin('om_customer', 'om_customer.id', '=', 'om_order.customer_id')
                        ->select('om_order.contract_sn', 'om_order.price', 'om_order.manager', 'om_order.buy_at', 'om_order.mark', 'om_order.order_at', 'om_customer.name', 'om_customer.contact', 'om_customer.customer_sn');
        $query->where('is_deleted',0);
        if(isset($data['contract_sn']) && $data['contract_sn']){//按合同编号查询
            $query->where('om_order.contract_sn','like','%'.$data['contract_sn'].'%');
        }
        if(isset($data['name']) && $data['name']){//按客户公司名称查询
            $query->where('om_customer.name','like','%'.$data['name'].'%');
        }
        if(isset($data['customer_sn']) && $data['customer_sn']){//按客户编号查询
            $query->where('om_customer.customer_sn','like','%'.$data['customer_sn'].'%');
        }
        if(isset($data['buy_start_at']) && isset($data['buy_end_at']) && $data['buy_start_at'] && $data['buy_end_at']){//按下单时间搜索
            $query->where('om_order.buy_at','>=',$data['buy_start_at'])->where('buy_at','<=',$data['buy_end_at']);
        }
        if(isset($data['order_start_at']) && isset($data['order_end_at']) && $data['order_start_at'] && $data['order_end_at']){//按交货时间搜索
            $query->where('om_order.order_at','>=',$data['order_start_at'])->where('order_at','<=',$data['order_end_at']);
        }
        $sort = isset($data['sort']) ? $data['sort'] : 'desc';
        if(isset($data['sort_type']) && $data['sort_type']){
            $query->orderBy($data['sort_type'], $sort);
        }
        $res['_count'] = $query->count();
        $res['data'] = $query->skip($offset)->take($limit)->orderBy('id', $sort)->get();

        return $res;
    }

    public function deleteOrder($data){
        $ids = isset($data['ids']) ? $data['ids'] : 0;
        $del = OmOrder::whereIn('id',$ids)->update('is_deleted',1);
        if(!$del){
            return ['status'=>false];
        }
        return ['status'=>true];
    }

    //验证规则
    public function OrderValidator($data,$id=''){
        $message = [
            'contract_sn.required' => '合同编号不能为空',
            'contract_sn.unique' => '合同编号已存在',
            'price.required' => '合同金额不能为空',
            'price.numeric' => '合同金额必须为数值',
            'manager.required' => '负责人不能为空',
            'buy_at.required' => '下单时间不能为空',
            'order_at.required' => '交货时间不能为空',
        ];

        $rule = [
            'contract_sn' => 'required|unique:om_order, contract_sn,'.$id,
            'price' => 'required|numeric',
            'manager' => 'required',
            'buy_at' => 'required',
            'order_at' => 'required',
        ];

        $res = $this->doValidate($data,$rule,$message);
        return $res;
    }

    public function getXjs($customer_id){
        $xjs = OmOrderGoods::leftJoin('om_goods','om_goods.id','=','om_order_goods.goods_id')
                           ->select('om_goods.img','om_goods.product_sn','om_goods.en_name','om_goods.cn_name','om_order_goods.*')
                           ->where('om_order_goods.customer_id',$customer_id)
                           ->where('om_order_goods.is_deleted',0)
                           ->where('om_order_goods.type',0)
                           ->get();
        foreach ($xjs as $k=>$v){
            $car_type = OmCarType::where(['goods_id'=>$v['goods_id'],'is_deleted'=>0])->orderBy('sort','DESC')->first();
            if($car_type){
                $xjs[$k]['car_type'] = $car_type['brand'].' '.$car_type['car_type'];
            }else{
                $xjs[$k]['car_type'] = '';
            }
            $supplier_id = OmGoodsSupplier::where(['goods_id'=>$v['goods_id'],'is_deleted'=>0])->orderBy('sort','DESC')->value('supplier_id');
            if($supplier_id){
                $xjs[$k]['supplier'] = OmSupplier::where('id',$supplier_id)->value('name');
            }else{
                $xjs[$k]['supplier'] = '';
            }
            $xjs[$k]['mfrs_sn'] = OmGoodsMfrs::where(['goods_id'=>$v['goods_id'],'is_deleted'=>0])->orderBy('sort','DESC')->value('mfrs_sn');
            $xjs[$k]['edit'] = false;
        }
        return $xjs;
    }

    public function postXjs($customer_id,$ids){
        $customer = OmCustomer::where('id',$customer_id)->first();
        if(!$customer){
            return ['status'=>false,'msg'=>'客户不存在'];
        }
        foreach ($ids as $k=>$v){
            $xj_data[$k]['customer_id'] = $customer_id;
            $xj_data[$k]['goods_id'] = $v;
            $xj_data[$k]['type'] = 0;
            $xj_data[$k]['created_at'] = Carbon::now();
        }
        $res = OmOrderGoods::insert($xj_data);
        if($res){
            return ['status'=>true];
        }else{
            return ['status'=>false,'msg'=>'询价记录添加失败'];
        }
    }

    public function putXj($id, $data){
        $save['fob_price'] = $data['fob_price'];
        $save['tax_price'] = $data['tax_price'];
        $save['price'] = $data['price'];

        $update = OmOrderGoods::where('id',$id)->update($save);
        if($update){
            return ['status'=>true];
        }else{
            return ['status'=>false,'msg'=>'询价记录操作失败'];
        }
    }

    public function deleteXj($id){
        $delete = OmOrderGoods::where('id',$id)->delete();
        if(!$delete){
            return ['status'=>false,'msg'=>'询价记录删除失败'];
        }else{
            return ['status'=>true];
        }
    }

    public function getCustomerOrders($customer_id){
        $orders = OmOrder::select('id','customer_id','contract_sn','price','manager','mark')->where(['customer_id'=>$customer_id,'is_deleted'=>0])->get();
        foreach ($orders as $k=>$v){
            $orders[$k]['edit'] = false;
        }
        return $orders;
    }

    public function getContractSn($customer_id){
        $carbon = new Carbon();
        $max_id = OmOrder::max('id');
        $contract_sn = 'BK'.substr($carbon->year,-2).($max_id + 1);
        return $contract_sn;
    }

}