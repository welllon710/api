<?php


namespace app\model;


use think\Model;

class Problem extends Model
{
    public function topic(){
        return $this->belongsTo(Topic::class,'topic_id','id');
    }
}