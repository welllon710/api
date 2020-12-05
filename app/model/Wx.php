<?php


namespace app\model;


use think\Model;
use think\model\concern\SoftDelete;

class Wx extends Model
{
//    public function article(){
//        return $this->hasMany(Article::class,'openid_id','id');
//    }
   // use SoftDelete;
    use SoftDelete;
    public function article(){
        return $this->belongsToMany(Article::class,Read::class);
    }

    public function getNickNameAttr($value){  //转换回来
        return base64_decode($value);
    }
}