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
        'driver' => getenv('DB_DRIVER'),
        'host'=> getenv('DB_HOST'),
        'database' => getenv('DB_NAME'),
        'user' => getenv('DB_LOGIN'),
        'password' => getenv('DB_PASS')
    ],
    'auth' => [
        'use' => true,
        'defaultAuthenticator' => 'jwt',
        'jwt' => [
            'secret' => 'uidt67dgwawdgyquwdvf',
            'lifetime' => 60 * 60 * 24
        ]
    ]
];
