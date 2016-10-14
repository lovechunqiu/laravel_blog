<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //设置表名
    protected $table = 'article';
    //设置主键
    protected $primaryKey = 'art_id';
    //默认时间
    public $timestamps = false;
    //排查不能填充的字段
    protected $guarded = [];
}
