<?php


namespace app\controller;


use app\BaseController;

class Cate extends BaseController
{

    //查询分类列表
    public function index(){
        $data = \app\model\Cate::field(['id','catename','sort'])->select();
        if ($data->isEmpty()){
            $this->return_msg([],'请求失败',400);
        }else{
            $this->return_msg($data,'请求成功',200);
        }
     //   $this->return_msg($all_cate,'查询成功',200);
    }
}