<?php


namespace app\controller;


use app\Request;
use think\Cache;
use think\Validate;

class Code extends Base
{

    public function get_code(){
     $username = $this->params['username'];//从处理后的参数取出想要的参数
     $judge = $this->check_username($username);   //判断是邮箱还是手机
     switch ($judge) {
         case 'email':
             $this->send_code($username,'email');
             break;
         case 'phone';
              $this->send_code($username,'phone');
              break;
     }
    }
    public function send_code($name,$type){
        if ($type === 'email'){
            $type_name = '邮箱';
        }else{
            $type_name = '手机';
        }
        //判断手机号或邮箱在数据库里是否存在
        $this->check_phone_email($type,$name); //字段 值
        echo '验证通过';
        //判断请求频率
        if (cache($name.'last_time')){
            if (time() - cache($name.'last_time') <= 30){
                $this->return_msg([],$type_name.'验证码请求频率过快，请30秒后再试');
            }
        }
        //生成验证码
        $code = $this->make_code(5);
        //保存验证码
        $_code = md5($code);
        cache($name.'code',$_code);
        cache($name.'last_time',time());

        if ($type === 'email'){
            //发送邮箱验证码
            echo 'email';
            $this->send_email($name,$code);
        }else{
            echo 'phoner';
            $this->send_phone($name,$code);
        }

    }
    public function send_email($name,$code){
       $res = emailto($name,'验证码','你的邮箱验证码是'.$code.'请在一分钟内使用');
       if ($res){
           $this->return_msg([],'发送成功',200);
       }else{
           $this->return_msg([],'发送失败',400);
       }
    }
    public function send_phone($name,$code){
        echo '发送手机验证码';
    }
}