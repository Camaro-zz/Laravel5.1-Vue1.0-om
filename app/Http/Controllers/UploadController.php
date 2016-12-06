<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request){
        //dd($request);
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            return ['status'=>false,'msg'=>'上传文件为空'];
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            return ['status'=>false,'msg'=>'文件上传出错'];
        }
        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $savePath = 'imgs/'.$newFileName;
        $bytes = Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );
        if(!Storage::exists($savePath)){
            return ['status'=>false,'msg'=>'文件上传失败'];
        }
        return ['status'=>true,'path'=>$savePath];
    }
}
