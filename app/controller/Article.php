<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\Article as ArticleModel;
class Article extends BaseController
{
    protected $field = ['id','title','desc','tags','content','is_top'];
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
        $article = new ArticleModel();
        $res = $article->add($data);
        if ($res === 1){
            $this->return_msg($data,'请求成功',200);
        }else{
            $this->return_msg($data,$res,400);



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
