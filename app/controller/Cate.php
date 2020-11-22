<?php


namespace app\controller;


use app\BaseController;

class Cate extends BaseController
{

    //查询分类列表
    public function get_cate(){
        $all_cate = \app\model\Cate::field(['id','catename','sort'])->select();
        $this->return_msg($all_cate,'查询成功',200);
    }
}