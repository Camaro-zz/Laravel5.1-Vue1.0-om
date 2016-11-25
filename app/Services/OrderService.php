<?php
namespace App\Services;


use App\Models\OmGoods;
use App\Models\OmOrder;
use App\Models\OmOrderGoods;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService {
    public function __construct(){
        $this->uid = Auth::user()->id;
    }

    //添加订单
    public function addOrder($data){
        $v = $this->OrderValidator($data);
        if(!$v['status']){
            return $v;
        }
        $data['uid'] = $this->uid;
        $order = OmOrder::create($data);
        if($order->id){
            isset($data['order_goods']) && $this->setOrderGoods($order, $data['order_goods']);
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
        $v = $this->OrderValidator($data);
        if(!$v['status']){
            return $v;
        }
        $order_id = OmOrder::where('id',$id)->update($data);
        if($order_id){
            isset($data['order_goods']) && $this->setOrderGoods($order, $data['order_goods']);
            $order = OmOrder::where('id',$order_id)->first();
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
}