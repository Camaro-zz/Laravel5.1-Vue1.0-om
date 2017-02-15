<?php

namespace App\Http\Controllers\Order;

use App\Services\OrderService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }

    public function postOrder($id, Request $request){
        $res = $this->orderService->addOrder($id,$request->all());
        return Response::json($res,200);
    }

    public function putOrder(Request $request, $id){
        $res = $this->orderService->editOrder($id, $request->all());
        return Response::json($res,200);
    }

    public function getOrder($id){
        $res = $this->orderService->getOrder($id);
        return Response::json($res,200);
    }

    public function getOrders(Request $request){
        $res = $this->orderService->getOrders($request->all());
        return Response::json($res,200);
    }

    public function getXjs($id){
        $res = $this->orderService->getXjs($id);
        return Response::json($res,200);
    }

    public function postXjs($id, Request $request){
        $data = $request->all();
        $ids = $data['ids'];
        $res = $this->orderService->postXjs($id,$ids);
        return Response::json($res,200);
    }

    public function putXj($id, Request $request){
        $res = $this->orderService->putXj($id,$request->all());
        return Response::json($res,200);
    }

    public function deleteXj($id){
        $res = $this->orderService->deleteXj($id);
        return Response::json($res,200);
    }

    public function getCustomerOrders($id){
        $res = $this->orderService->getCustomerOrders($id);
        return Response::json($res,200);
    }

    public function getContractSn($id){
        $res = $this->orderService->getContractSn($id);
        return Response::json($res,200);
    }
}
