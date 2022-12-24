<?php
return [
    'default' => [
        'host' => 'redis://'.getenv('RDS_HOST').':'.getenv('RDS_PORT'),
        'options' => [
            'auth' => getenv('RDS_PASSWORD'),       // 密码，字符串类型，可选参数
            'db' => getenv('RDS_DATABASE'),            // 数据库
            'prefix' => getenv('RDS_PREFIX').'queue_',       // key 前缀
            'max_attempts'  => 3, // 消费失败后，重试次数
            'retry_seconds' => 0, // 重试间隔，单位秒
        ]
    ],
];
