<?php

namespace App\Http\Controllers\Goods;

use App\Services\GoodsCatService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class GoodsCatController extends Controller
{
    public function __construct(GoodsCatService $goodsCatService){
        $this->goodsCatService = $goodsCatService;
    }

    public function postCat(Request $request){
        $data = $this->goodsCatService->addCat($request->all());
        return Response::json($data);
    }

    public function putCat($id, Request $request){
        $data = $this->goodsCatService->editCat($id, $request->all());
        return Response::json($data);
    }

    public function deleteCats(Request $request){
        $ids = $request->all()->ids;
        $data = $this->goodsCatService->deleteCats($ids);
        return Response::json($data);
    }

    public function getCat($id){
        $data = $this->goodsCatService->getCat($id);
        return Response::json($data);
    }

    public function getCats(Request $request){
        $data = $this->goodsCatService->getCats($request->all());
        return Response::json($data);
    }
}
