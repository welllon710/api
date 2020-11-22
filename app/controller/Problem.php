<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use think\Request;

class Problem extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    protected $field = ['id','problem','answer','topic_id'];
    public function index()
    {
        $problem = new \app\model\Problem();
        $data =  $problem->field(['id','problem','answer','topic_id'])
            ->paginate($this->page_size,false);
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
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
       $topic = \app\model\Topic::with(['problem'])->where('id',$id)->find();
        $data = $topic->problem()->field($this->field)
           ->paginate($this->page_size,false);
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
