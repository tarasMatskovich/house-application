<?php

use WyriHaximus\React\ChildProcess\Pool\Options;
use \app\launcher\MultiProcessApplicationLauncher;

require './vendor/autoload.php';

define('ROOT_DIRECTORY', dirname(__FILE__));

require './bootstrap/bootstrap.php';

$options = [
    Options::MIN_SIZE => 1,
    Options::MAX_SIZE => 5,
    Options::TTL      => 20,
];

$applicationLauncher = new MultiProcessApplicationLauncher(
    $config,
    $routerFactory,
    $eventListener,
    \houseframework\app\factory\enum\ApplicationTypesEnum::APP_WAMP
);
$applicationLauncher->launch($options);

