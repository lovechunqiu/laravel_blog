<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class NavsController extends Controller
{

    //get.admin/navs  全部自定义导航列表
    public function index()
    {
        $data = navs::orderBy('nav_order', 'asc')->get();
        return view('admin.navs.index', compact('data'));
    }

    //post.admin/navs/create 添加自定义导航
    public function create()
    {
        return view('admin.navs.add');
    }

    //post.admin/navs 添加自定义导航提交
    public function store()
    {
        $input = Input::except('_token');
        //验证规则
        $rules = [
            'nav_name' => 'required',
            'nav_url'  => 'required',
        ];
        //自定义内容
        $message = [
            'nav_name.required' => '自定义导航名称不能为空！',
            'nav_url.required'  => 'url不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = navs::create($input);
            if($re){
                return redirect('admin/navs');
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

    //get.admin/navs/{navs}/edit 编辑自定义导航
    public function edit($nav_id)
    {
        $field = navs::find($nav_id);
        return view('admin.navs.edit', compact('field'));
    }

    //put.admin/navs/{navs} 更新自定义导航
    public function update($nav_id)
    {
        //剔除不要的参数
        $input = Input::except('_token', '_method');
        $re = navs::where('nav_id', $nav_id)->update($input);
        if($re){
            return redirect('admin/navs');
        }else{
            return back()->with('errors', '自定义导航信息更新失败，请稍后重试！');
        }
    }

    //delete.admin/navs/{navs} 删除单个自定义导航
    public function destroy($nav_id)
    {
        $re = navs::where('nav_id', $nav_id)->delete();
        if($re){
            //成功
            $data = array(
                'status' => 0,
                'msg' => '自定义导航删除成功！',
            );
        }else{
            //失败
            $data = array(
                'status' => 1,
                'msg' => '自定义导航删除失败，请稍后重试！',
            );
        }
        return $data;
    }

    public function changeorder()
    {
        $input = Input::all();
        $navs = navs::find($input['nav_id']);
        $navs->nav_order = $input['nav_order'];
        $re = $navs->update();
        if($re){
            //成功
            $data = array(
                'status' => 0,
                'msg' => '自定义导航排序更新成功！',
            );
        }else{
            //失败
            $data = array(
                'status' => 1,
                'msg' => '自定义导航排序更新失败，请稍后重试！',
            );
        }
        return $data;
    }
}
