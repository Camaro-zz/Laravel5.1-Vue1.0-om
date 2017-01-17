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

    public function getSuppliersByGoods($id){
        $data = $this->goodsService->getSuppliersByGoods($id);
        return Response::json($data,200);
    }

    public function getGoodsImgs($id){
        $data = $this->goodsService->getGoodsImgs($id);
        return Response::json($data,200);
    }

    public function postGoodsImgs($id, Request $request){
        $data = $this->goodsService->postGoodsImgs($id, $request->all());
        return Response::json($data,200);
    }

    public function postGoodsImg($id, Request $request){
        $data = $this->goodsService->postGoodsImg($id, $request->all());
        return Response::json($data,200);
    }

    public function deleteGoodsImg($id, Request $request){
        $data = $this->goodsService->deleteGoodsImg($id, $request->all());
        return Response::json($data,200);
    }

    public function getGoodsCarTypes($id){
        $data = $this->goodsService->getGoodsCarTypes($id);
        return Response::json($data,200);
    }

    public function deleteGoodsCarTypes(Request $request){
        $ids = $request->all()->ids;
        $data = $this->goodsService->deleteGoodsCarTypes($ids);
        return Response::json($data);
    }

    public function deleteGoodsCarType($id){
        $ids = [$id];
        $data = $this->goodsService->deleteGoodsCarTypes($ids);
        return Response::json($data);
    }

    public function postGoodsCarType(Request $request, $id){
        $data = $this->goodsService->postGoodsCarType($request->all(), $id);
        return Response::json($data,200);
    }

    public function putGoodsCarType(Request $request, $id){
        $data = $this->goodsService->putGoodsCarType($request->all(), $id);
        return Response::json($data,200);
    }

    public function sortGoodsCarType(Request $request, $id){
        $data = $this->goodsService->sortGoodsCarType($request->all(), $id);
        return Response::json($data,200);
    }

    public function deleteGoodsSupplier($id){
        $data = $this->goodsService->deleteGoodsSupplier($id);
        return Response::json($data,200);
    }
    
}
