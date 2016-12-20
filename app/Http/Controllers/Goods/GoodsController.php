<?php

namespace App\Http\Controllers\Goods;

use App\Services\GoodsService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class GoodsController extends Controller
{
    public function __construct(GoodsService $goodsService){
        $this->goodsService = $goodsService;
    }

    //添加商品
    public function postGoods(Request $request){
        $data = $this->goodsService->addGoods($request->all());
        return Response::json($data,200);
    }

    //添加供应商商品
    public function postSupplierGoods(Request $request, $id){
        $data = $this->goodsService->addSupplierGoods($id, $request->all());
        return Response::json($data,200);
    }

    //编辑供应商商品
    public function putSupplierGoods(Request $request, $id){
        $data = $this->goodsService->editSupplierGoods($id, $request->all());
        return Response::json($data,200);
    }

    //编辑商品
    public function putGoods($id, Request $request){
        $data = $this->goodsService->editGoods($id, $request->all());
        return Response::json($data,200);
    }

    //商品详情
    public function getGoods($id){
        $data = $this->goodsService->getGoods($id);
        return Response::json($data,200);
    }

    //商品列表
    public function getGoodses(Request $request){
        $data = $this->goodsService->getGoodses($request->all());
        return Response::json($data,200);
    }

    //商品删除
    public function deleteGoodses(Request $request){
        $ids = $request->all();
        $data = $this->goodsService->deleteGoodses($ids['ids']);
        return Response::json($data,200);
    }

    public function postMfrsGoods(Request $request, $id){
        $data = $this->goodsService->postMfrsGoods($id, $request->all());
        return Response::json($data,200);
    }

    public function getMfrsByGoods($id){
        $data = $this->goodsService->getMfrsByGoods($id);
        return Response::json($data,200);
    }

    public function getSupplierByGoods($id){
        $data = $this->goodsService->getSupplierByGoods($id);
        return Response::json($data,200);
    }

    public function getGoodsImgs($id){
        $data = $this->goodsService->getGoodsImgs($id);
        return Response::json($data,200);
    }
    
}
