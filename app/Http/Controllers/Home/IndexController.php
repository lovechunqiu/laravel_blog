<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Model\Navs;

class IndexController extends CommonController
{
    public function index()
    {
        //点击量最高的6篇文章（站长推荐）
        $pics = Article::orderBy('art_view', 'desc')->take(6)->get();

        //点击量最高的5篇文章
        $hot = Article::orderBy('art_view', 'desc')->take(5)->get();

        //图文列表5篇（带分页）
        $data = Article::orderBy('art_time', 'desc')->paginate(5);

        //最新发布的8篇文章
        $new = Article::orderBy('art_time', 'desc')->take(8)->get();

        //友情链接
        $links = Links::orderBy('link_order', 'asc')->get();

        return view('home/index', compact('hot', 'data', 'new', 'links', 'pics'));
    }

    public function cate($cate_id)
    {
        $field = Category::find($cate_id);

        //图文列表5篇（带分页）
        $data = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(4);

        return view('home/list', compact('field', 'data'));
    }

    public function article()
    {
        return view('home/new');
    }
}
