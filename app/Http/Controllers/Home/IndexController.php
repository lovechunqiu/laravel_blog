<?php

namespace App\Http\Controllers\Home;

class IndexController extends CommonController
{
    public function index()
    {
        return view('home/index');
    }

    public function cate()
    {
        return view('home/list');
    }

    public function art()
    {
        return view('home/new');
    }
}
