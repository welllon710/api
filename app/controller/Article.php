<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use app\model\Read;
use think\facade\Cache;
use think\Request;
use app\model\Article as ArticleModel;
class Article extends BaseController
{
    protected $field = ['id','title','desc','tags','content','is_top','create_time'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data = \app\model\Article::field($this->field)->paginate($this->page_size,false);
        if ($data->isEmpty()){
            $this->return_msg([],'请求失败',400);
        }else{
            $this->return_msg($data,'请求成功',200);
        }
    }
    public function detail(){
      $param = \request()->param(['uid','time','openid']);
        $data = \app\model\Article::where('id',$param['uid'])
            ->find();//文章详情
        $data->read_time = time();
        $data->save();
        \cache('goin'.$param['uid'],$param['time']);//存入缓存
        $wx_id = \app\model\Wx::with('article')->where('openid',$param['openid'])->value('id');//找到该用户
       \cache('id'.$param['uid'],$wx_id); //用户id存入缓存
        if ($data->isEmpty() ){
            $this->return_msg([],'请求失败',400);
        }else{
            $this->return_msg($data,'请求成功',200);
        }


    }
    public function leavedetail(){
        $uid = input('get.uid');
        $leave = input('get.leavetime');
        cache('leave'.$uid,$leave);
        $diff = Cache::pull('leave'.$uid) - Cache::pull('goin'.$uid);
        if ($diff <= 30){
          $this->return_msg([],'再多读会吧~',204);
        }else{
            $wx_id = \cache('id'.$uid);
            $bool = Read::where([
                'wx_id'=>$wx_id,
                'article_id'=>$uid
            ])->find();
           if ($bool){
               $this->return_msg([],'温故而知新',200);
           }else{
              $data = Read::create([
                   'wx_id'=>$wx_id,
                   'article_id'=>$uid
               ]);
               $this->return_msg([],'阅读量+1！',200);
           }
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
      //  $data = $request->param();
      //  $this->return_msg($data,'请求成功',200);
        $data = [
            'title'=>input('post.title'),
            'desc'=>input('post.desc'),
            'tags'=>input('post.tags'),
            'content'=>input('post.content'),
            'is_top'=>input('post.is_top')?'1':'0',
            'cate_id'=>input('post.cate_id'),
            'openid'=>input('post.myid')
        ];
        // $data['cate_id'] = \app\model\Cate::where('catename',$data['cate_id'])->value('id');
        // $data['myid'] = \app\model\Wx::where('id',$data[''])
        $article = new ArticleModel();
        $res = $article->add($data);
        if ($res === 1){
            $this->return_msg($data,'请求成功',200);
        }else{
            $this->return_msg($data,'请求失败',400);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */

    public function read($id) //返回分类下的文章
    {
        $cate = \app\model\Cate::with(['article'])->find($id);
        $data = $cate->article()->field($this->field)->order('create_time','desc')->paginate($this->page_size,false);
        if ($data->isEmpty()){
            $this->return_msg([],'请求失败',400);
        }else{
            $this->return_msg($data,'请求成功',200);
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
