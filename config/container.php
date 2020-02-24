<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:22
 */

namespace config;

use app\factories\UserFactory\UserFactory;
use app\factories\UserFactory\UserFactoryInterface;
use app\responders\UserResponder\UserResponder;
use app\responders\UserResponder\UserResponderInterface;
use app\services\Authentication\Authenticator\Factory\AuthenticatorFactory;
use app\services\Authentication\Authenticator\Factory\AuthenticatorFactoryInterface;
use app\services\Authentication\Authenticator\JWTAuthenticator;
use app\services\UserPasswordService\UserPasswordService;
use app\services\UserPasswordService\UserPasswordServiceInterface;
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
        UserResponderInterface::class => UserResponder::class,
        'application.authenticator.jwt' => function (ContainerInterface $container) {
            return new JWTAuthenticator(
                $container->get('application.entityManager')->getMapper('User'),
                $container->get('application.config')->get('auth:jwt:secret'),
                $container->get('application.config')->get('auth:jwt:lifetime')
            );
        },
        AuthenticatorFactoryInterface::class => function (ContainerInterface $container) {
            return new AuthenticatorFactory(
                $container->get('application.authenticator.jwt')
            );
        },
    ],
    'singletons' => [

    ]
];
