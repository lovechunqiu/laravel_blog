<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login(){
        //判断是否是post提交
        if($input = Input::all()){
            //判断验证码
            if(strtoupper($input['code']) != $this->_getCode()){
                return back()->with('msg', '验证码错误');
            }
            echo 'ok';
        }else{
            return view('admin.login');
        }
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
