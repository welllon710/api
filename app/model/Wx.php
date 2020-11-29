<?php


namespace app\model;


use think\Model;

class Wx extends Model
{
    public function article(){
        return $this->hasMany(Article::class,'openid_id','id');
    }

}