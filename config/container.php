<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:22
 */

namespace houseapp\config;

use houseframework\app\request\builder\RequestBuilder;
use houseframework\app\request\builder\RequestBuilderInterface;

return [
    'definitions' => [
        RequestBuilderInterface::class => RequestBuilder::class
    ],
    'singletons' => [

    ]
];
