<?php
namespace App\Services;


use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersService extends BaseService {

    public function __construct(Users $users){
        $this->model = $users;
    }

    //修改密码
    public function putPassword($data){
        $password = bcrypt($data['password']);
        $old_password = $data['oldpassword'];
        if(!Hash::check($old_password,Auth::user()->password)){
            return false;
        }
        $id = Auth::user()->id;
        if($this->model->where(array('id'=>$id))->update(array('password'=>$password))) {
            return true;
        }
        return false;
    }

}