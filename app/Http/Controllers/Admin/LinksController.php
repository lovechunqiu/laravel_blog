<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class LinksController extends Controller
{

    //get.admin/links  全部友情链接列表
    public function index()
    {
        $data = Links::orderBy('link_order', 'asc')->get();
        return view('admin.links.index', compact('data'));
    }

    //post.admin/links/create 添加友情链接
    public function create()
    {
        return view('admin.links.add');
    }

    //post.admin/links 添加友情链接提交
    public function store()
    {
        $input = Input::except('_token');
        //验证规则
        $rules = [
            'link_name' => 'required',
            'link_url'  => 'required',
        ];
        //自定义内容
        $message = [
            'link_name.required' => '友情链接名称不能为空！',
            'link_url.required'  => 'url不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Links::create($input);
            if($re){
                return redirect('admin/links');
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

    //get.admin/links/{links}/edit 编辑友情链接
    public function edit($link_id)
    {
        $field = Links::find($link_id);
        return view('admin.links.edit', compact('field'));
    }

    //put.admin/links/{links} 更新友情链接
    public function update($link_id)
    {
        //剔除不要的参数
        $input = Input::except('_token', '_method');
        $re = Links::where('link_id', $link_id)->update($input);
        if($re){
            return redirect('admin/links');
        }else{
            return back()->with('errors', '友情链接信息更新失败，请稍后重试！');
        }
    }

    //delete.admin/links/{links} 删除单个友情链接
    public function destroy($link_id)
    {
        $re = Links::where('link_id', $link_id)->delete();
        if($re){
            //成功
            $data = array(
                'status' => 0,
                'msg' => '友情链接删除成功！',
            );
        }else{
            //失败
            $data = array(
                'status' => 1,
                'msg' => '友情链接删除失败，请稍后重试！',
            );
        }
        return $data;
    }

    public function changeorder()
    {
        $input = Input::all();
        $links = Links::find($input['link_id']);
        $links->link_order = $input['link_order'];
        $re = $links->update();
        if($re){
            //成功
            $data = array(
                'status' => 0,
                'msg' => '友情链接排序更新成功！',
            );
        }else{
            //失败
            $data = array(
                'status' => 1,
                'msg' => '友情链接排序更新失败，请稍后重试！',
            );
        }
        return $data;
    }
}
