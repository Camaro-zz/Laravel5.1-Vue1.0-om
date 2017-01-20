<?php

namespace App\Http\Controllers\Supplier;

use App\Services\SupplierService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SupplierController extends Controller
{
    public function __construct(SupplierService $supplierService){
        $this->supplierService = $supplierService;
    }

    //添加供应商
    public function postSupplier(){
        $data = $this->supplierService->addSupplier();
        return Response::json($data, 200);
    }

    //编辑供应商
    public function putSupplier($id, Request $request){
        $data = $this->supplierService->editSupplier($id, $request->all());
        return Response::json($data, 200);
    }

    //供应商列表
    public function getSuppliers(Request $request){
        $data = $this->supplierService->getSuppliers($request->all());
        return Response::json($data, 200);
    }

    //供应商详情
    public function getSupplier($id){
        $data = $this->supplierService->getSupplier($id);
        return Response::json($data, 200);
    }

    public function putSupplierSort($id, Request $request){
        $data = $this->supplierService->putSupplierSort($id, $request->all());
        return Response::json($data,200);
    }

    public function getSupplierGoods($id){
        $data = $this->supplierService->getSupplierGoods($id);
        return Response::json($data,200);
    }

    public function postSupplierGoods($id, Request $request){
        $data = $this->supplierService->postSupplierGoods($id, $request->all());
        return Response::json($data,200);
    }

    public function getSupplierMaxId(){
        $data = $this->supplierService->getSupplierMaxId();
        return Response::json($data,200);
    }

    public function postSupplierByGoods($goods_id, Request $request){
        $data = $this->supplierService->postSupplierByGoods($goods_id, $request->all());
        return Response::json($data,200);
    }
}
