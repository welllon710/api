<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\Comment as CommentModel;
class Comment extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {



    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {

            $data = [
                'wx_id'=>input('post.wxid'),
                'article_id'=>input('post.uid'),
                'content'=>base64_encode(input('post.value')),
                'parent_id'=>input('post.parent_id',0)
            ];
            $data['nickname'] = $data['wx_id'];
            $comment = new \app\model\Comment();
            $bool = $comment->add($data);
            if ($bool == 1){
                $this->return_msg([],'回复成功',200);
            }else{
                $this->return_msg([],$bool,400);
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
      $data =  $this->getcomment($id);
      if (empty($data)){
          $this->return_msg([],'请传入正确的文章id',200);
      }else{
          $this->return_msg($data,'请求成功',200);
      }
    }
    public function getcomment($article_id,$comment_id = 0){ //文章id , 回复的父评论的id
        $result = [];
        $arr = CommentModel::where('article_id',$article_id)->where('comment_id',$comment_id)
            ->order('create_time','desc')->select();
        if ($arr->isEmpty()){
           //$this->return_msg([],'文章id不存在',404);
            return  array();
        }
        foreach ($arr as $k=>$v){
            $v['child'] = $this->getcomment($article_id,$v['id']);
            $v['content'] = base64_decode( $v['content']);
          //  $v['nickname'] = base64_decode($v['nickname']);
            $result[] = $v->toArray();
        }
       return  $result;
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
