<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 30.01.2020
 * Time: 17:41
 */

require './vendor/autoload.php';

define('ROOT_DIRECTORY', dirname(__FILE__));

require './bootstrap/bootstrap.php';


$container->set('application.type', \houseframework\app\factory\enum\ApplicationTypesEnum::APP_WAMP);
$applicationLauncher = new \app\launcher\ApplicationLauncher(
    $container,
    $routerFactory,
    $bootstrapper,
    \houseframework\app\factory\enum\ApplicationTypesEnum::APP_WAMP
);

$applicationLauncher->launch();
