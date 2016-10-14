<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
    //get.admin/category  全部分类列表
    public function index()
    {
        $data = (new Category)->tree();
        return view('admin.category.index')->with('data', $data);

    }

    //post.admin/category
    public function store()
    {

    }

    //post.admin/category/create 添加分类
    public function create()
    {

    }

    //get.admin/category/{category} 显示单个分类信息
    public function show()
    {

    }

    //get.admin/category/{category} 删除单个分类
    public function destory()
    {

    }

    //put.admin/category/{category} 更新分类
    public function update()
    {

    }

    //get.admin/category/{category}/edit 编辑分类
    public function edit()
    {

    }

    public function changeorder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if($re){
            //成功
            $data = array(
                'status' => 0,
                'msg' => '分类排序更新成功！',
            );
        }else{
            //失败
            $data = array(
                'status' => 1,
                'msg' => '分类排序更新失败，请稍后重试！',
            );
        }
        return $data;
    }

}
