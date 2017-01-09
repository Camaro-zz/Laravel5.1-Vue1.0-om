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

    public function postOrder(Request $request){
        $res = $this->orderService->addOrder($request->all());
        return Response::json($res,200);
    }

    public function putOrder(Request $request, $id){
        $res = $this->orderService->editOrder($request->all($id, $request->all()));
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

    public function getCustomerOrders($id){
        $res = $this->orderService->getCustomerOrders($id);
        return Response::json($res,200);
    }
}
