<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use think\Request;

class Wx extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
       // $code = input('get.code');
        $openid = cache('openid');
        $openid =  \app\model\Wx::where('openid',$openid)->value('openid');
        $argc = \app\model\Article::where('openid',$openid)->field(['id','title','tags','create_time'])
            ->order('create_time','desc')
            ->select();
        if ($argc->isEmpty()){
            $this->return_msg([],'请求失败',400);
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
        $data['user']['gender'] = $data['user']['gender'] === 1?'男':'女';
        $openid = $data['user']['openid'];
        unset( $data['user']['openid']);
        $res = \app\model\Wx::where('openid',$openid)->update($data['user']);
        $wx = \app\model\Wx::where('openid',$openid)
            ->field(['id','nickname','gender','avatarurl','country','create_time'])->find();
        if ($res === 1){
            $this->return_msg($wx,'登录成功',200);
        }else{
            $this->return_msg($wx,'欢迎再次登录',200);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
         $openid = cache('openid');
         $read = \app\model\Wx::where('openid',$openid)
         ->find();
        $user = $read->article->visible(['id','title','tags','read_time'])->toArray();
       // $user = $user->order('read_time','desc');
        //dd($user->toArray());
        if (empty($user)){
            $this->return_msg([],'请求失败',400);
        }else{
            $this->return_msg($user,'请求成功',200);
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
