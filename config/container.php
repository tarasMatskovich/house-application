<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:22
 */

namespace houseapp\config;

use houseapp\app\factories\UserFactory\UserFactory;
use houseapp\app\factories\UserFactory\UserFactoryInterface;
use houseapp\app\responders\UserResponder\UserResponder;
use houseapp\app\responders\UserResponder\UserResponderInterface;
use houseapp\app\services\AuthenticationService\AuthenticationService;
use houseapp\app\services\AuthenticationService\AuthenticationServiceInterface;
use houseapp\app\services\JWTService\JWTService;
use houseapp\app\services\JWTService\JWTServiceInterface;
use houseapp\app\services\UserPasswordService\UserPasswordService;
use houseapp\app\services\UserPasswordService\UserPasswordServiceInterface;
use housedi\ContainerInterface;
use houseframework\app\request\builder\RequestBuilder;
use houseframework\app\request\builder\RequestBuilderInterface;

return [
    'definitions' => [
        RequestBuilderInterface::class => RequestBuilder::class,
        UserFactoryInterface::class => function (ContainerInterface $container) {
            return new UserFactory(
                $container->get('application.entityManager')->getMapper('User'),
                $container->get(UserPasswordServiceInterface::class)
            );
        },
        UserPasswordServiceInterface::class => UserPasswordService::class,
        JWTServiceInterface::class => function (ContainerInterface $container) {
            return new JWTService($container->get('application.config')->get('auth:secret'));
        },
        AuthenticationServiceInterface::class => function (ContainerInterface $container) {
            return new AuthenticationService(
                $container->get('application.entityManager')->getMapper('User'),
                $container->get(UserPasswordServiceInterface::class),
                $container->get(JWTServiceInterface::class)
            );
        },
        UserResponderInterface::class => UserResponder::class
    ],
    'singletons' => [

    ]
];
