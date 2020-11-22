<?php


namespace app\model;


use think\Model;

class Cate extends  Model
{
    public function article(){
        return $this->hasMany(Article::class,'cate_id','id');
    }
}