<?php


namespace app\controller;
use app\model\Wx;

use app\BaseController;

class Login extends BaseController
{
    public function index(){

        $Code = input('post.code');
        $Appid = 'wx5c11b99fea88a1d8';
        $AppSecret = 'bb8fb6576b53e40e5f7e7ec69217356e';
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
       // https://api.weixin.qq.com/sns/jscode2session?appid=wx5c11b99fea88a1d8&secret=1945df0738fc405ea32bad58cac8f283&js_code=033T5KFa18582A04kfHa1s94rs0T5KFc&grant_type=authorization_code
        $url = sprintf($url,$Appid,$AppSecret,$Code);
        $res = geturl($url);
        $wx = new Wx();
        if (isset($res['errcode'])){
            $this->return_msg($res,'请求失败',200);
        }else{
            try {
                $result = $wx->save(['openid'=>$res['openid']]);
                cache('openid',$res['openid']); //存入openid
                if ($result){
                    $this->return_msg($res,'请求成功',200);
                }else{
                    $this->return_msg($res,'服务器错误',500);
                }
            }catch (\Exception $E){
               // $result = $wx->save(['openid'=>$res['openid']]);
                cache('openid',$res['openid']); //存入openid
                $this->return_msg($res,'重复登陆了哦',400);
            }


        }


    }
}