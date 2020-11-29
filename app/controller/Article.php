<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use think\App;
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

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->param();
      //  $this->return_msg($data,'请求成功',200);
        $data['cate_id'] = \app\model\Cate::where('catename',$data['cate_id'])->value('id');
        $article = new ArticleModel();
        $res = $article->add($data);
        if ($res === 1){
            $this->return_msg($data,'请求成功',200);
        }else{
            $this->return_msg($data,$res,400);

        }
    }
    public function detail(){
        //问题、第二次发起请求，会覆盖第一次的参数
        $this->id = input('uid');
        $goin_time = input('time');//进去页面的时间戳
        cache('goin',$goin_time);
        $data = ArticleModel::where('id', $this->id)->find();
          if ($data->isEmpty()){
              $this->return_msg([],'请求失败',400);
          }else{
              $this->return_msg($data,'请求成功',200);
          }

    }
    public function leavedetail(){
        $leave = input('leavetime');
        $uid = input('uid');
        \cache('leavetime',$leave);
    //  dd(\cache('goin'),\cache('leavetime'));
        $diff = Cache::pull('leavetime') - Cache::pull('goin');
        if ($diff >= 30){
            $data = ArticleModel::where('id', $uid)->find();
            $data->is_read = 1;
            $read = $data->save();
            if ($read){
                $this->return_msg([],'阅读量+1',200);
            }
        }else{
            $this->return_msg([],'阅读时间不够哦',202);
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
        $cate = \app\model\Cate::with(['article'])->find($id);
        $data = $cate->article()->field($this->field)->paginate($this->page_size,false);
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
