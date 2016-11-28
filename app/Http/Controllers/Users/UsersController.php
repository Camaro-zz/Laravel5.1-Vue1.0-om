<?php

namespace App\Http\Controllers\Users;

use App\Services\UsersService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UsersController extends Controller
{
    public function __construct(UsersService $usersService){
        $this->service = $usersService;
    }

    public function putPassword(Request $request){
        $data = $this->service->putPassword($request->all());
        if($data){
            return Response::json(array('success'=>true));
        }else{
            return Response::json(array('error'=>array('message'=>'请输入正确的旧密码', 'type'=>'operation failed', 'code'=>'1000002')),422);
        }
    }

    /**
     * 获取登陆用户信息
     *
     * @return Response
     */
    public function getMe()
    {
        $user = [
            'account' => Auth::user() ? Auth::user() : 0,
        ];
        return Response::json($user);
    }
}
