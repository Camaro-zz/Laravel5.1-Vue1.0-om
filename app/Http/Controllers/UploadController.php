<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class UploadController extends Controller
{
    public function upload(Request $request){
        return ['status'=>false,'msg'=>'asasa'];
    }
}
