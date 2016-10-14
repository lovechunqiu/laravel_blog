<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //设置表名
    protected $table = 'category';
    //设置主键
    protected $primaryKey = 'cate_id';
    //默认时间
    public $timestamps = false;
}
