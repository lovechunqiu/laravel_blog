<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class LinksController extends Controller
{

    //get.admin/links  全部友情链接列表
    public function index()
    {
        $data = Links::orderBy('link_order', 'asc')->get();
        return view('admin.links.index', compact('data'));
    }

    public function show()
    {

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
