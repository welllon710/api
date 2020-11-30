<?php


namespace app\model;


use app\validate\Article as ArticleValidate;
use think\Model;

class Article extends Model
{
    public function add($data){
        $validate = new ArticleValidate();
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
    public function getCreateTimeAttr($value){ //获取器转好为时间戳
        return strtotime($value);
    }

}