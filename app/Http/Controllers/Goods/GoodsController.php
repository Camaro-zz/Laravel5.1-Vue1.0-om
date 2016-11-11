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
        $data = $this->goodsService->getGoods($request->all());
        return Response::json($data,200);
    }

    //商品删除
    public function deleteGoodses(Request $request){
        $ids = $request->all()->ids;
        $data = $this->goodsService->deleteGoodses($ids);
        return Response::json($data,200);
    }
}
