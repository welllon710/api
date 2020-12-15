<?php


namespace app\model;


use think\Model;
use think\model\concern\SoftDelete;

class Wx extends Model
{
    //use SoftDelete;
//    public function article(){
//        return $this->hasMany(Article::class,'openid_id','id');
//    }

    public function article(){
        return $this->belongsToMany(Article::class,Read::class);
    }


}