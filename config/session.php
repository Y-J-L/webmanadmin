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

use Webman\Session\FileSessionHandler;
use Webman\Session\RedisSessionHandler;
use Webman\Session\RedisClusterSessionHandler;

return [

    'type' => 'redis', // or redis or redis_cluster

    'handler' => RedisSessionHandler::class,

    'config' => [
        'file' => [
            'save_path' => runtime_path() . '/sessions',
        ],
        'redis' => [
            'host' => getenv('RDS_HOST'),
            'port' => getenv('RDS_PORT'),
            'auth' =>  getenv('RDS_PASSWORD'),
            'timeout' => 2,
            'database' => getenv('RDS_DATABASE'),
            'prefix' => getenv('RDS_PREFIX').'redis_session_',
        ],
        'redis_cluster' => [
            'host' => ['127.0.0.1:7000', '127.0.0.1:7001', '127.0.0.1:7001'],
            'timeout' => 2,
            'auth' => '',
            'prefix' => 'redis_session_',
        ]
    ],

    'session_name' => 'PHPSID',
    
    'auto_update_timestamp' => true,

    'lifetime' => 30*24*60*60,

    'cookie_lifetime' => 365*24*60*60,

    'cookie_path' => '/',

    'domain' => '',
    
    'http_only' => true,

    'secure' => false,
    
    'same_site' => '',

    'gc_probability' => [1, 1000],

];
