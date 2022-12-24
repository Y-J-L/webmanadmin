<?php
namespace app\middleware;

use app\admin\constants\CacheKeyConstants;
use app\admin\constants\CacheTagConstants;
use Shopwwi\LaravelCache\Cache;
use support\Log;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;
use Webman\RedisQueue\Client;

//跨域请求中间件
class Access implements MiddlewareInterface
{
    public function process(Request $request, callable $next) : Response
    {
        $header = [
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Origin' => $request->header('origin', '*'),
            'Access-Control-Allow-Methods' => $request->header('access-control-request-method', '*'),
            'Access-Control-Allow-Headers' => $request->header('access-control-request-headers', '*'),
        ];

        //判断是否是options请求
        if($request->method() == 'OPTIONS'){
           return response('',200,$header);
        }

        //组合请求记录数据
        $request_log = [];
        $start_time = microtime(true);
        $request_log['ip'] = $request->getRealIp();
        $request_log['method'] = $request->method();
        $request_log['fullurl'] = trim($request->fullUrl(), '/');
        $request_log['app'] = $request->app;
        $request_log['controller'] = end(explode("\\",$request->controller));
        $request_log['action'] = $request->action;
        $request_log['route'] = $request->route ? $request->route->getPath():'';

        //今日请求量增加
         $request_pv_cache_key = 'request_pv_'.strtotime(date('Y-m-d 00:00:00'));
         $day_pv = Cache::tags(CacheTagConstants::CACHE_TAG_REQUEST_INFO)->get($request_pv_cache_key) ?? 0;
         Cache::tags(CacheTagConstants::CACHE_TAG_REQUEST_INFO)->increment($request_pv_cache_key);

        // //站点总请求量
         $total_pv = Cache::tags(CacheTagConstants::CACHE_TAG_REQUEST_INFO)->get(CacheKeyConstants::CACHE_KEY_REQUEST_PV_TOTAL,0);
         Cache::tags(CacheTagConstants::CACHE_TAG_REQUEST_INFO)->increment(CacheKeyConstants::CACHE_KEY_REQUEST_PV_TOTAL);

        // 如果是opitons请求则返回一个空的响应，否则继续向洋葱芯穿越，并得到一个响应
        $response = $next($request);

        //请求耗时,ms
        $request_log['times'] = sprintf("%.3f",(microtime(true) - $start_time) * 1000);


        // 给响应添加跨域相关的http头
        $response->withHeaders($header);

        $exception = $response->exception();
        if ($exception) {
            //捕获异常
            $request_log['exception'] = $exception->getMessage();
            Log::error('请求异常:'.(string)$exception);
        }

        Client::send('request_log',$request_log);

        return $response;
    }
    
}
