<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    public function postLogin(){
        $input = array(
            'username' => Input::get('username'),//用户名
            'password' => Input::get('password'),//密码
            'captcha'  => Input::get('captcha')//验证码
        );
        $rules = array (
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        );

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            $this->clearCaptcha();//验证失败的话清除验证码的session
            return Response::json(['error' => ['message'=>$validator->getMessageBag()->toArray(), 'type'=>'Auth', 'code'=>401]]);
        }else{

        }
        
    }

    public function getLogout(){

    }

    public function getCaptcha(){
        echo captcha_img();
    }

    private function setLoginAtSession($uid)
    {
        Session::put('login.session'.$uid, time());
    }

    private function clearCaptcha()
    {
        Session::forget('captcha');
    }
}
