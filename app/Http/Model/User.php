<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //设置表名
    protected $table = 'user';
    //设置主键
    protected $primaryKey = 'user_id';
    //默认时间
    public $timestamps = false;
}
