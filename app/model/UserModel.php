<?php

namespace app\model;

use app\admin\constants\CacheTagConstants;
use Shopwwi\LaravelCache\Cache;
use think\Model;

/**
 *用户模型
 */
class UserModel extends BaseModel
{
    
    protected $name = 'user';


    //获取用户登陆token
    public function getToken($uid){

        if(!$uid) return [];

        $token = md5(uniqid($uid).uniqid());

        $ttl = 86400 * 30;//有效期30天，可根据业务调整
        Cache::tags(CacheTagConstants::CACHE_TAG_USER_TOKEN)->set('usertoken_'.$token,$uid,$ttl);

        $userinfo = get_userinfo($uid,true);

        return ['token'=>$token,'userinfo'=>$userinfo];
    }

}
