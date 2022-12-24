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

return [
    'default' => [
        'host' => getenv('RDS_HOST'),
        'password' => getenv('RDS_PASSWORD'),
        'port' => getenv('RDS_PORT'),
        'database' => getenv('RDS_DATABASE'),
        'prefix' => getenv('RDS_PREFIX'),
        'expire' => getenv('RDS_EXPIRE'),
    ],
];