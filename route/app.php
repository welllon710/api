<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::group('api',function (){

   //获取注册的验证码
   Route::rule('code','Code/get_code','get');
   //注册
   Route::rule('register','User/register','post');
   //登录
 //   Route::rule('login','User/login','post');
    //获取分类
    Route::rule('cate','Cate/get_cate','get');
    //文章
    Route::resource('article','Article');
    Route::rule('articles/detail','Article/detail','get'); //进入文章详情
    Route::rule('leave/detail','Article/leavedetail','get');//离开详情页
    //获取试题
    Route::resource('problem','Problem');
    //试题分类
    Route::resource('topic','Topic');
    //小程序登录
    Route::rule('login','Login/index','post');
    //小程序用户
    Route::resource('wx','Wx');

   // Route::rule('wxs/reads','Wx/reads','get');

});
