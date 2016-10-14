<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //get.admin/article  全部文章列表
    public function index()
    {

        $data = Article::orderBy('art_id', 'desc')->paginate(10);
        return view('admin.article.index', compact('data'));
    }

    //post.admin/article/create 添加文章
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.article.add', compact('data'));
    }

    //post.admin/article 添加文章提交
    public function store()
    {
        $input = Input::except('_token');
        //验证规则
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        //自定义内容
        $message = [
            'art_title.required'  => '文章标题不能为空！',
            'art_content.required'  => '文章内容不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['art_time'] = time();
            $re = Article::create($input);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors', '数据填充失败，请稍后重试！');
            }
        }else{
            //打印错误信息
            //dd($validator->errors()->all());
            return back()->withErrors($validator);
        }


    }
}
