<?php

use app\admin\constants\CacheTagConstants;
use app\model\AdminModel;
use app\model\AdminRolesModel;
use app\model\OptionModel;
use app\model\UserModel;
use Shopwwi\LaravelCache\Cache;


/**
 * 获取用户信息
 * $uid 用户id
 * $is_update 是否强制更新
 * return array
 */
function get_userinfo($uid, $is_update = false){

    if(!$uid) return [];

    $user = Cache::tags(CacheTagConstants::CACHE_TAG_USER_INFO)->get('userinfo_'.$uid);

    if(!$user || $is_update){
        //更新用户信息
        $userModel = new UserModel();
        $user = $userModel->find($uid)->toArray();
        if(!$user) return [];
        unset($user['password']);
        Cache::tags(CacheTagConstants::CACHE_TAG_USER_INFO)->set('userinfo_'.$uid,$user);
    }

    return $user;
}

//获取配置
function get_option($name){

    //获取缓存
    $value = Cache::tags(CacheTagConstants::CACHE_TAG_OPTION)->get('wb_option_'.$name);
    if(!$value){
        //查询数据
        $optionModel = new OptionModel();
        $option = $optionModel->where("option_name",$name)->find();
        
        if(isset($option['option_value'])){
            $option = $option->toArray();
            Cache::tags(CacheTagConstants::CACHE_TAG_OPTION)->set('wb_option_'.$name,$option['option_value']);
            $value = $option['option_value'];
        }else{
            $value = [];
        }
    }

    return $value;
}

//获取配置下的某个key
function get_option_key($name,$key,$default=''){

    $option = get_option($name);

    if(!isset($option[$key]) || empty($option[$key])){
        return $default;
    }

    return $option[$key];
}

 //返回请求类型 http:// or https://
function get_http_type(){
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

    return $http_type;
}

//获取当前管理员id
function get_admin_id(){
    $session = session();

    return $session->get('admin_id') ?? 0;
}

//获取当前管理员角色权限
function get_admin_rules(){

    $admin_id = get_admin_id();

    if(!$admin_id){
        return [];
    }

    $rules = Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_RULES)->get('admin_rules_'.$admin_id);
    if(!$rules){
        $adminModel = new AdminModel();
        $admin = $adminModel->find($admin_id);
        $rolesModel = new AdminRolesModel;
        $roles = $rolesModel->where("id",'in',$admin['roles'])->select();

        if(!$roles) return [];

        $rules = [];
        foreach($roles as $k=>$v){
            $rules = array_merge($rules,explode(",",$v['rules']));
        }

        //清除数组空内容，清除数组重复内容
        $rules = array_filter(array_unique($rules));
        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_RULES)->set('admin_rules_'.$admin_id,$rules);
    }

    return $rules;
}

//获取当前管理员信息
function get_admin_info(){
    $admin_id = get_admin_id();

    $admin = Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_INFO)->get('admin_info_'.$admin_id);
    if(!$admin){
        $adminModel = new AdminModel();
        $admin = $adminModel->find($admin_id)->toArray();

        Cache::tags(CacheTagConstants::CACHE_TAG_ADMIN_INFO)->set('admin_info_'.$admin_id,$admin);
    }

    return $admin;
}

//判断是否是post请求
function is_post(){
    $request = request();
   
    return $request->method() == 'POST' ? true:false;
}


//判断是否是get请求
function is_get(){
    $request = request();
   

    return $request->method() == 'GET' ? true:false;
}

/**
 * 登录密码加密
 * $password 密码
 * $salt 加密盐
 */
function get_password($password,$salt=''){

    return '###'.md5(md5($password.$salt));
}

/**
 * 检查手机格式，中国手机不带国家代码，国际手机号格式为：国家代码-手机号
 * @param $mobile
 * @return bool
 */
function check_mobile($mobile)
{
    if (preg_match('/(^(13\d|14\d|15\d|16\d|17\d|18\d|19\d)\d{8})$/', $mobile)) {
        return true;
    } else {
        if (preg_match('/^\d{1,4}-\d{5,11}$/', $mobile)) {
            if (preg_match('/^\d{1,4}-0+/', $mobile)) {
                //不能以0开头
                return false;
            }

            return true;
        }

        return false;
    }
}