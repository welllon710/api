<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Comment extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'wx_id'=>'require',
        'article_id'=>'require',
        'nickname'=>'require',
        'content'=>'require',
        'parent_id'=>'require'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'wx_id.require'=>'你还没有登录哦'
    ];
    protected $scene = [
        'add'=>['wx_id','nickname','article_id','content','parent_id']
    ];
}
