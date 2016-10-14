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

    //get.admin/article/{article}/edit 编辑文章
    public function edit($art_id)
    {
        $field = Article::find($art_id);
        $data = (new Category)->tree();
        return view('admin.article.edit', compact('field', 'data'));
    }

    //put.admin/article/{article} 更新文章
    public function update($art_id)
    {
        //剔除不要的参数
        $input = Input::except('_token', '_method');
        $re = Article::where('art_id', $art_id)->update($input);
        if($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors', '文章更新失败，请稍后重试！');
        }
    }

    public function show()
    {
        
    }

    //delete.admin/article/{article} 删除单个文章
    public function destroy($art_id)
    {
        $re = Article::where('art_id', $art_id)->delete();
        if($re){
            //成功
            $data = array(
                'status' => 0,
                'msg' => '文章删除成功！',
            );
        }else{
            //失败
            $data = array(
                'status' => 1,
                'msg' => '文章删除失败，请稍后重试！',
            );
        }
        return $data;
    }

}
