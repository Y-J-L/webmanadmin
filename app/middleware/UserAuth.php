<?php
namespace app\middleware;

use app\admin\constants\CacheTagConstants;
use Shopwwi\LaravelCache\Cache;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class UserAuth implements MiddlewareInterface
{
    public function process(Request $request, callable $next) : Response
    {

        $controller = $request->controller;

        if($controller != 'app\user\controller\PublicController'){
            //验证用户是否登陆
            $token = $request->header('USER-Token');

            $uid = Cache::tags(CacheTagConstants::CACHE_TAG_USER_TOKEN)->get('usertoken_'.$token);
            if(!$uid || !$token) return error('请先登陆',[],[],10001);

            $userinfo = get_userinfo($uid,true);
            if(!$userinfo['status']) return error('用户被禁用');

            $request->uid = $uid;
            $request->userinfo = $userinfo;

            return $next($request);
        }
        
    }
    
}
