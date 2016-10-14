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

    public function tree()
    {
        $categorys = $this->all();
        $data = $this->getTree($categorys, 'cate_name', 'cate_id', 'cate_pid');
        return $data;
    }

    public function getTree($data,$field_name,$field_id='id',$field_pid='pid', $pid = 0)
    {
        $arr = array();
        foreach($data as $k => $v){
            if($v->$field_pid == $pid){
                $data[$k]["_" . $field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach($data as $m => $n){
                    if($n->$field_pid == $v->$field_id){
                        $data[$m]["_" . $field_name] = '├─ ' . $data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
