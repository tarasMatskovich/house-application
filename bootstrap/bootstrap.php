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
$routerFactory = new \houseframework\app\router\factory\RouterFactory($routes, $httpRoutes);


$containerDefinitions = require ROOT_DIRECTORY . '/config/container.php';
$container = new \housedi\Container($containerDefinitions);
$bootstrapper = new \houseapp\bootstrap\bootstrapper\Bootstrapper();

$configParams = require  ROOT_DIRECTORY . '/config/config.php';
$config = new \houseframework\app\config\Config($configParams);
$container->set('application.config', $config);
