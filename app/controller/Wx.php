<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use think\model\Relation;
use think\Request;

class Wx extends BaseController
{

    public function pub()
    {
        $openid = input('post.code');
        $argc = \app\model\Article::where('openid',$openid)->field(['id','title','tags','create_time'])
            ->order('create_time','desc')
            ->select();
        if ($argc->isEmpty()){
            $this->return_msg([],'空空如也呢!',400);
        }else{
            $this->return_msg($argc,'请求成功',200);
        }
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->param();
        $data['user']['nickname'] = base64_encode( $data['user']['nickname']);
        $data['user']['gender'] = $data['user']['gender'] === 1?'男':'女';
        $openid = $data['user']['openid'];
        unset( $data['user']['openid']);
        $res = \app\model\Wx::where('openid',$openid)->find();//判断是否再次登录
        if ($res == null){
            $user =  \app\model\Wx::onlyTrashed()->where('openid',$openid)
                ->field(['id','nickname','gender','avatarurl','country','create_time'])
                ->find();
            $result =  $user->restore();
            $this->return_msg($user,'欢迎再次登录~',200);
        }
        $update = \app\model\Wx::where('openid',$openid)->update($data['user']);
        $wx = \app\model\Wx::where('openid',$openid)
            ->field(['id','nickname','gender','avatarurl','country','create_time'])->find();
        if ($update === 1){
            $this->return_msg($wx,'登录成功',200);
        }
    }

    public function read()
    {
         $openid = input('post.code');
         $read = \app\model\Wx::where('openid',$openid)->find();
         $user = $read->article->visible(['id','title','tags','read_time']);//？？？时间排序

        if ($user->isEmpty()){
            $this->return_msg([],'您还没有阅读呢,赶快去阅读吧',400);
        }else{

            $this->return_msg($user,'请求成功',200);
        }
    }

    public function delete($id)
    {
       $data = \app\model\Wx::find($id)->delete();
        //$data = \app\model\Wx::find($id);
       if ($data){
           $this->return_msg([],'退出成功',200);
       }else{
           $this->return_msg([],'退出失败',400);
       }
    }
}
