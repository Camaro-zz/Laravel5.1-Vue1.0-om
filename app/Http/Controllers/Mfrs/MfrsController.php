<?php

namespace App\Http\Controllers\Mfrs;

use App\Services\MfrsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class MfrsController extends Controller
{
    public function __construct(MfrsService $mfrsService){
        $this->mfrsService = $mfrsService;
    }

    public function getMfrs($id){
        $data = $this->mfrsService->getMfrs($id);
        return Response::json($data,200);
    }

    public function putMfrs($id, Request $request){
        $data = $this->mfrsService->putMfrs($id, $request->all());
        return Response::json($data,200);
    }

    public function putMfrsSort($id, Request $request){
        $data = $this->mfrsService->putMfrsSort($id, $request->all());
        return Response::json($data,200);
    }

    public function deleteMfrs($id){
        $data = $this->mfrsService->deleteMfrs($id);
        return Response::json($data,200);
    }
}
