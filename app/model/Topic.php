<?php


namespace app\model;


use think\Model;

class Topic extends Model
{
    public function problem(){
        return $this->hasMany(Problem::class,'topic_id','id');
    }
}