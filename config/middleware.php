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

use app\middleware\Access;
use app\middleware\AdminAuth;
use app\middleware\UserAuth;

return [
    //全局中间件
    ''=>[
        Access::class,//跨域请求
    ],
    //admin模块中间件
    'admin'=>[
        AdminAuth::class
    ],
    'user'=>[
        UserAuth::class
    ],
];