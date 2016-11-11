<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Response;

class AuthApi
{

    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd($this->auth->guest());
        if ($this->auth->guest())
        {
            return Response::json('没有权限', 401);
        }
        /*if ($this->checkAuthUser()) {
            return Response::json('没有权限', 401);
        }
        if (!$this->checkPriv($request->route()->uri(), strtolower($request->method()))) {
            return Response::json('没有权限', 401);
        }*/

        return $next($request);
    }

    /*private function checkPriv($uri, $method)
    {
        $key = $uri.'.'.$method;
        $configPrivs = config('privs.api');
        $code = isset($configPrivs[$key]) ? $configPrivs[$key] : '';
        //过滤不显示的权限code(如标准版不显示推客，合伙人)
        $excludeCode = $this->privService->getExcludePrivs();
        if($code && array_intersect($code, $excludeCode)) {
            return false;
        }
        if($this->auth->user()->is_admin) {
            return true;
        }

        if(!$code) {
            return true;
        } else {
            $userPrivs = $this->userService->getUserPrivs();
            if(!$userPrivs || !array_intersect($code, $userPrivs)) {
                return false;
            }
        }
        return true;
    }

    private function checkAuthUser()
    {
        if($this->auth->user()->password_at > 0) {
            $sessionLoginAt = Session::get('login.session'.$this->auth->user()->id);
            $passwordAt = strtotime($this->auth->user()->password_at);
            if($sessionLoginAt && $sessionLoginAt < $passwordAt) {
                $this->auth->logout();
                return true;
            }
        }
        return false;
    }*/
}
