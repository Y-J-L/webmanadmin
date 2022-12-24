<?php
namespace app\queue\redis\fast;

use app\model\RequestLogModel;
use Shopwwi\LaravelCache\Cache;
use support\Log;
use Webman\RedisQueue\Consumer;

/**
 * 请求日志记录队列
 */
class RequestLog implements Consumer
{
    // 要消费的队列名
    public $queue = 'request_log';

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public $connection = 'default';

    // 消费
    public function consume($data)
    {
        $data['create_time'] = time();

        try{

            RequestLogModel::create($data);

        }catch(\Throwable $e){

            Log::error('request_log_queue error:'.(string)$e,$data);
        }

        //-----------------------使用缓存锁防止并发示例(laravel-cache)-----------------------------
        //注意，队列中捕获到异常后不会重试该任务，如果想重试任务请抛出异常
        //使用缓存锁防止并发demo,
        // try{

        //     $seconds = 0;//任务最大执行时间 0则为不限制时间
        //     $block_seconds = 10;//等待获取锁时间 0则为立即获取,获取不到则返回错误
        //     Cache::lock('testlock',$seconds)->block($block_seconds,function(){
                    
        //             //执行具体任务...

        //     });

        // }catch(\Throwable $e){
        //     echo "lockdemo执行错误:".(string)$e."\n";
        //     //新增消费失败表，存储任务名、参数、失败原因，方便后期排查并重新执行
        // }

    }
}