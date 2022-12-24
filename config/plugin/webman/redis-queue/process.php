<?php
return [
    //不同队列设置不同消费进程
    //快速消费且多进程
    'redis_consumer_fast'  => [
        'handler'     => Webman\RedisQueue\Process\Consumer::class,
        'count'       => 8, // 可以设置多进程同时消费
        'constructor' => [
            // 消费者类目录
            'consumer_dir' => app_path() . '/queue/redis/fast'
        ]
    ],
    //单进程消费 ..可根据需求扩展，例如需要控制并发的业务,即时不用锁，也可以防止并发
    // 'redis_consumer_one'  => [
    //     'handler'     => Webman\RedisQueue\Process\Consumer::class,
    //     'count'       => 1, // 可以设置多进程同时消费
    //     'constructor' => [
    //         // 消费者类目录
    //         'consumer_dir' => app_path() . '/queue/redis/one'
    //     ]
    // ],
];