<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class ConfigController extends Controller
{

    //get.admin/config  全部配置项列表
    public function index()
    {
        $data = config::orderBy('conf_order', 'asc')->get();
        return view('admin.config.index', compact('data'));
    }

    //post.admin/config/create 添加配置项
    public function create()
    {
        return view('admin.config.add');
    }

    //post.admin/config 添加配置项提交
    public function store()
    {
        $input = Input::except('_token');
        //验证规则
        $rules = [
            'conf_title'  => 'required',
            'conf_name' => 'required',
        ];
        //自定义内容
        $message = [
            'conf_title.required'  => '配置项标题不能为空！',
            'conf_name.required' => '配置项名称不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors', '数据填充失败，请稍后重试！');
            }
        }else{
            //打印错误信息
            //dd($validator->errors()->all());
            return back()->withErrors($validator);
        }
    }

    public function show()
    {

    }

    //get.admin/config/{config}/edit 编辑配置项
    public function edit($conf_id)
    {
        $field = config::find($conf_id);
        return view('admin.config.edit', compact('field'));
    }

    //put.admin/config/{config} 更新配置项
    public function update($conf_id)
    {
        //剔除不要的参数
        $input = Input::except('_token', '_method');
        $re = config::where('conf_id', $conf_id)->update($input);
        if($re){
            return redirect('admin/config');
        }else{
            return back()->with('errors', '配置项信息更新失败，请稍后重试！');
        }
    }

    //delete.admin/config/{config} 删除单个配置项
    public function destroy($conf_id)
    {
        $re = config::where('conf_id', $conf_id)->delete();
        if($re){
            //成功
            $data = array(
                'status' => 0,
                'msg' => '配置项删除成功！',
            );
        }else{
            //失败
            $data = array(
                'status' => 1,
                'msg' => '配置项删除失败，请稍后重试！',
            );
        }
        return $data;
    }

    public function changeorder()
    {
        $input = Input::all();
        $config = config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $re = $config->update();
        if($re){
            //成功
            $data = array(
                'status' => 0,
                'msg' => '配置项排序更新成功！',
            );
        }else{
            //失败
            $data = array(
                'status' => 1,
                'msg' => '配置项排序更新失败，请稍后重试！',
            );
        }
        return $data;
    }
}
