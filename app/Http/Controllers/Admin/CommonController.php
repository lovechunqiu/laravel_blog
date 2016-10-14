<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload()
    {
        $file = Input::file('Filedata');
        //判断文件是否有效
        if($file->isValid()){
            //上传文件的后缀
            $entension = $file->getClientOriginalExtension();
            //重组文件名
            $newName = date('YmdHis') . mt_rand(100,999) . '.' . $entension;
            //移动文件，文件全路径
            $path = $file->move(base_path() . '/uploads', $newName);
            //文件路径
            $filepath = 'uploads/' . $newName;
            return $filepath;
        }
    }
}
