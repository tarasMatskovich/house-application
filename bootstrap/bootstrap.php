<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:24
 */

$env = \Dotenv\Dotenv::createImmutable(ROOT_DIRECTORY);
$env->load();

$routes = require ROOT_DIRECTORY . '/config/routes.php';
$httpRoutes = require  ROOT_DIRECTORY . '/config/http_routes.php';
$channels = require ROOT_DIRECTORY . '/config/channels.php';
$routerFactory = new \houseframework\app\router\factory\RouterFactory($routes, $httpRoutes);


$containerDefinitions = require ROOT_DIRECTORY . '/config/container.php';
$container = new \housedi\Container($containerDefinitions);
$bootstrapper = new \bootstrap\bootstrapper\Bootstrapper();

$configParams = require  ROOT_DIRECTORY . '/config/config.php';
$config = new \houseframework\app\config\Config($configParams);
$container->set('application.config', $config);

$eventListener = new \houseframework\app\eventlistener\EventListener($channels);
$container->set(
    \houseframework\app\eventlistener\EventListenerInterface::class,
    $eventListener
);
