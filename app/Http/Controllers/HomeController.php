<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{

    public function __construct(){
        
    }

    public function index(){

        if(!isset(Auth::user()->id)){
            return Redirect::to('auth/login');
        }
        $global['user'] = Auth::user()->toArray();
        $global['img_path'] = '';
        $data['global'] = json_encode($global);
        return view('home',$data);
    }
}
