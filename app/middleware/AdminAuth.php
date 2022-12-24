<?php
namespace app\middleware;

use app\admin\Auth;
use support\View;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class AdminAuth implements MiddlewareInterface
{
    public function process(Request $request, callable $next) : Response
    {

        View::assign('PUBLIC_PATH',public_path());
        View::assign('HTTP_STATIC_PATH',get_http_type().$request->host().'/public/static/');
        View::assign('HTTP_PUBLIC_PATH',get_http_type().$request->host().'/public/');
        View::assign('APP_PATH',app_path());

        $controller = $request->controller;
        $action = $request->action;
        $app = $request->app;

        if($controller != 'app\admin\controller\PublicController'){

            //管理员鉴权,验证登录、权限、返回权限菜单
            $admin_id = get_admin_id();
            if(empty($admin_id)){
                return redirect('/admin/public/login');
            }
            
            //权限验证
            if(!Auth::canAccess($controller,$action,$app)){
                return error('没有访问权限!');
            }

        }


        return $next($request);
    }
    
}
