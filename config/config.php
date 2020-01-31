<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 15:09
 */

return [
    'transport' => [
        'wamp' => [
            'realm' => getenv('WAMP_REALM'),
            'url' => getenv('WAMP_URL')
        ]
    ],
    'database' => [
        'db_name' => getenv('DB_NAME'),
        'login' => getenv('DB_LOGIN'),
        'password' => getenv('DB_PASS'),
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'driver' => getenv('DB_DRIVER')
    ],
];
