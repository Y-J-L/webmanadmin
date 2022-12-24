<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use app\admin\controller\AdminController;
use app\admin\controller\IndexController;
use app\admin\controller\MenuController;
use app\admin\controller\PublicController;
use app\admin\controller\RolesController;
use app\admin\controller\UserController;
use app\api\controller\UploadController;
use app\middleware\AdminAuth;
use app\middleware\UserAuth;
use app\user\controller\IndexController as UserIndexController;
use app\user\controller\PublicController as UserPublicController;
use Webman\Route;

//首页
Route::any('/',function(){
    return redirect('/admin/public/login');
});

//前端路由
Route::group('/api',function(){

    //无需登陆
    Route::group('/',function(){
        //单文件/多文件 上传
        Route::post('upload',[UploadController::class,'upload']);

        //---------------------用户-----------------------
        Route::post('user/login',[UserPublicController::class,'login']);//用户登陆
        Route::post('user/register',[UserPublicController::class,'register']);//注册
        Route::post('user/send_register_code',[UserPublicController::class,'sendRegisterCode']);//发送注册验证码

    });

    //需要登陆
    Route::group('/',function(){

        //---------------------用户-----------------------
        Route::get('user/index',[UserIndexController::class,'index']);

    })->middleware([
        UserAuth::class
    ]);



});

//后台直达
Route::any('/admin',function(){
    return redirect('/admin/public/login');
});

//后台路由
Route::group('/admin',function(){

    //无需登录
    Route::group('/',function(){
        Route::any('public/login',[PublicController::class,'login']);
        //验证码
        Route::get('public/captcha',[PublicController::class,'captcha']);
    });

    //强制登录
    Route::group('/',function(){

        //退出登陆
        Route::get('index/logout',[IndexController::class,'logout']);

        Route::get('index/index',[IndexController::class,'index']);
        Route::get('index/menu',[IndexController::class,'menu']);//管理员获取左侧菜单
        Route::get('index/main',[IndexController::class,'main']);
        Route::any('index/syssetting',[IndexController::class,'sysSetting']);
        Route::get('index/uploadlist',[IndexController::class,'uploadlist']);
        Route::get('index/getuploadlist',[IndexController::class,'getUploadList']);
        Route::get('index/requestlog',[IndexController::class,'requestlog']);
        Route::get('index/getrequestlog',[IndexController::class,'getRequestLog']);
        Route::delete('index/requestlogdel',[IndexController::class,'requestlogDel']);//删除请求记录
        Route::get('index/exportrequestlog',[IndexController::class,'exportrequestlog']);//导出请求记录

        //菜单管理
        Route::get('menu/index',[MenuController::class,'index']);
        Route::get('menu/list',[MenuController::class,'list']);
        Route::any('menu/edit',[MenuController::class,'edit']);
        Route::delete('menu/del',[MenuController::class,'del']);
        Route::any('menu/sellist',[MenuController::class,'sellist']);//选择树级菜单
        Route::any('menu/initMenu',[MenuController::class,'initMenu']);//初始化菜单(仅限初始化用)

        //角色管理
        Route::get('roles/index',[RolesController::class,'index']);
        Route::any('roles/edit',[RolesController::class,'edit']);
        Route::get('roles/getmenu',[RolesController::class,'getmenu']);//获取菜单复选框
        Route::any('roles/getlist',[RolesController::class,'getlist']);
        Route::delete('roles/del',[RolesController::class,'del']);

        //管理员管理
        Route::get('admin/index',[AdminController::class,'index']);
        Route::any('admin/edit',[AdminController::class,'edit']);
        Route::get('admin/getlist',[AdminController::class,'getlist']);
        Route::delete('admin/del',[AdminController::class,'del']);
        Route::any('admin/updstatus',[AdminController::class,'updstatus']);

        //会员管理
        Route::get('user/index',[UserController::class,'index']);
        Route::get('user/getlist',[UserController::class,'getlist']);
        Route::post('user/updstatus',[UserController::class,'updstatus']);


    })->middleware([
        AdminAuth::class
    ]);




});

//不存在的路由,返回404
Route::fallback(function(){
    return json(['code' => 0, 'msg' => '404 not found']);
});

//关闭默认路由
Route::disableDefaultRoute();



