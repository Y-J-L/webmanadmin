<?php
namespace app\admin;

use app\model\AdminMenuModel;
use support\View;

//鉴权类
class Auth {

    /**
     * 验证是否有权限
     */
    static function canAccess($controller,$action,$app){

        //用户角色
        $rules = get_admin_rules();

        //判断超级管理员
        if(in_array('*',$rules)){
            return true;
        }

        //格式化controller
        $controller = str_replace('Controller','',end(explode("\\",$controller)));

        //判断权限是否添加到数据库
        $menuModel = new AdminMenuModel();
        $menu = $menuModel->where([
            ['action','=',$action],
            ['controller','=',$controller],
            ['app','=',$app]
        ])->find();

        //未添加的权限，默认放行
        if(!$menu) return true;

        //验证权限
        if(in_array($menu['id'],$rules)){
            return true;
        }

        return false;
    }


}