<?php

namespace App\Http\Controllers\Auth;

use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Redirect;
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
            //'captcha'  => Input::get('captcha')//验证码
        );
        $rules = array (
            'username' => 'required',
            'password' => 'required',
            //'captcha' => 'required|captcha'
        );

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            //$this->clearCaptcha();//验证失败的话清除验证码的session
            return Response::json(['error' => ['message'=>['login'=>false,'captcha'=>true], 'type'=>'Auth', 'code'=>401]]);
        }else{
            //认证凭证
            $credentials = [
                'username' => Input::get('username'),
                'password' => Input::get('password')
            ];


            if (Auth::validate($credentials)) {
                Auth::login(Auth::getLastAttempted());
                //event(new UserLogin(Auth::user()));//处理用户登录事件

                //在session中存入登录时间
                $this->setLoginAtSession(Auth::user()->id);
                return Response::json(['success'=>true], 200);
            } else {
                //判断登录密码用md5是否能验证成功
                $valid = $this->validateMd5Password($input['username'], $input['password']);
                if($valid) {
                    if($password = $this->updateBcryptPassword($input['username'], $input['password'])) {
                        if (Auth::validate($credentials)) {
                            Auth::login(Auth::getLastAttempted());
                            //event(new UserLogin(Auth::user()));

                            //在session中存入登录时间
                            $this->setLoginAtSession(Auth::user()->id);

                            return Response::json(['success'=>true], 200);
                        }
                    }
                    //$this->clearCaptcha();
                    return Response::json(['error'=>['message'=>['login'=>'“登录失败，请重新登录！','captcha'=>false], 'type'=>'Auth', 'code'=>401]]);
                } else {
                    $this->clearCaptcha();
                    return Response::json(['error'=>['message'=>['login'=>'“用户名”或“密码”错误，请重新登录！','captcha'=>false], 'type'=>'Auth', 'code'=>401]]);
                }
            }

        }
        
    }

    public function getLogin()
    {
        $global['user'] = Auth::user() ? Auth::user()->toArray() : '';
        //dd($global);
        $data['global'] = json_encode($global);
        return view('home',$data);
    }

    public function getLogout(){
        /*if(Auth::user()) {
            event(new UserLogout(Auth::user()));
        }*/
        Auth::logout();
        return Redirect::to('auth/login');

       /* if(isset($_GET['runUrl'])){
            return redirect()->guest('auth/login');
        }

        return Response::json(['success'=>true], 200);*/
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

    public function validateMd5Password($un, $pwd)
    {
        //DB::connection()->enableQueryLog();
        $count = Users::where('username', $un)->where('password', md5($pwd))->count();
        //$queries = DB::getQueryLog();
        //dd($queries);
        return $count > 0 ? true : false;
    }

    public function updateBcryptPassword($un, $pwd)
    {
        $res = Users::where('username', $un)->update(['password'=>bcrypt($pwd)]);
        if($res) {
            return bcrypt($pwd);
        }
        return false;
    }
}
