<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login(){
        //判断是否是post提交
        if($input = Input::all()){
            //判断验证码
            if(strtoupper($input['code']) != $this->_getCode()){
                return back()->with('msg', '验证码错误！');
            }
            $user = User::first();
            if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass) != $input['user_pass']){
                return back()->with('msg', '用户名或者密码错误！');
            }
            //存储信息
            session(['user' => $user]);
//            dd(session('user'));
            return redirect('admin/index');
        }else{
//            dd($_SERVER);
            return view('admin.login');
        }
    }

    public function crypt(){
        $str = '123456';
        $str_p = Crypt::encrypt($str);
        echo $str_p;
        echo '<br>';
        echo Crypt::decrypt($str_p);
    }

    public function logout(){
        session(['user' => null]);
        return redirect('admin/login');
    }

    public function code(){
        $code = new \Code;
        $code->make();
    }

    /**
     * 取出验证码
     * @return mixed
     */
    private function _getCode(){
        $code = new \Code;
        return $code->get();
    }

}
