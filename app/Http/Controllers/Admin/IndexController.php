<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index(){
        return view('admin.index');
    }

    public function info(){
        return view('admin.info');
    }

    /**
     * 更改超级管理员密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pass(){
        if($input = Input::all()){
            //验证规则
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            //自定义内容
            $message = [
                'password.required'  => '新密码不能为空！',
                'password.between'   => '新密码必须在6-20为之间！',
                'password.confirmed' => '新密码和确认密码不一致！',
            ];
            $validator = Validator::make($input,$rules,$message);
            if($validator->passes()){
                $user = User::first();
                //解析原密码
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o'] == $_password){
                    //密码替换
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors', '密码修改成功！');
                }else{
                    return back()->with('errors', '原密码错误！');
                }
            }else{
                //打印错误信息
                //dd($validator->errors()->all());
                return back()->withErrors($validator);
            }

        }else {
            return view('admin.pass');
        }
    }
}
