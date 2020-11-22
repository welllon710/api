<?php


namespace app\controller;


use app\Request;
use think\Cache;
use think\Validate;
class User extends  Base
{

    public function register(){
        $data = $this->params;
        //验证验证码
        $this->check_code($data['username'],$data['code']);
        /*此时username 是手机号或者邮箱，不代表最终入库的值
          需要判断邮箱？手机？决定入库的字段
         * */
        $judge = $this->check_username($data['username']);   //判断是邮箱还是手机
        switch ($judge) {
            case 'email':
                $data['email'] = $data['username'];
                break;
            case 'phone';
                $data['phone'] = $data['username'];
                break;
        }
        //准备入库
        unset($data['username']);//字段已经转换完毕了，工具属性，抛弃,此时还报错 code
        $res = \app\model\User::create($data)->getData('id');
        if (empty($res)){
            $this->return_msg([],'注册失败',400);
        }else{
            $this->return_msg($res,'注册成功',200);
        }

    }
    //登录
    public function login(){
        $data = $this->params;
        $judge = $this->check_username($data['username']);   //判断是邮箱还是手机
        switch ($judge) {
            case 'email':
              $res = \app\model\User::where('email',$data['username'])->find();
                break;
            case 'phone';
               $res = \app\model\User::where('phone',$data['username'])->find();
                break;
        }
        //验证密码
        if ($data['password'] !== $res->password){
            $this->return_msg([],'密码错误',400);
        }else{
            $res = $res->toArray();
            unset($res['password']);
            $this->return_msg($res,'登录成功',200);
        }

    }
    public function aaa(){
        echo 'ceshi';
    }
}