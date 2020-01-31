<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:42
 */

namespace houseapp\bootstrap\scripts;


use housedi\ContainerInterface;
use houseframework\app\request\pipeline\builder\PipelineBuilder;
use houseframework\app\request\pipeline\builder\PipelineBuilderInterface;


/**
 * Class PipelineBootstrapScript
 * @package houseapp\bootstrap\scripts
 */
class PipelineBootstrapScript implements BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container)
    {
        $middlewares = [];

//        $middleware = new AuthenticationMiddleware(
//            $container->get('application.entityManager')->getRepository(User::class),
//            $container->get(AuthenticationServiceInterface::class)
//        );
//        $container->set(
//            'application.middleware.authentication',
//            $middleware
//        );
//        $middlewares[] = $middleware;
//        $skippedActions = [
//            'action.user.signup' => [
//                AuthenticationMiddleware::class
//            ],
//            'action.user.signin' => [
//                AuthenticationMiddleware::class
//            ]
//        ];

        $pipelineBuilder = new PipelineBuilder($middlewares, []);
        $container->set(PipelineBuilderInterface::class, $pipelineBuilder);
    }
}
