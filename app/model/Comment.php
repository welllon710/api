<?php


namespace app\model;


use think\Model;
use app\validate\Comment as CommentValidate;
class Comment extends Model
{
    public function add($data){
        $validate = new CommentValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $res = $this->save($data);
        if ($res){
            return 1;
        }else{
            return '添加失败';
        }
    }
    public function reply($data){
        $validate = new CommentValidate();
        if(!$validate->scene('reply')->check($data)){
            return $validate->getError();
        }
        $res = $this->save($data);
        if ($res){
            return 1;
        }else{
            return '添加失败';
        }
    }
    public function getParentNameAttr($value){
       return Wx::where('id',$value)->value('nickname');
    }
}