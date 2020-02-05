<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:42
 */

namespace houseapp\bootstrap\scripts;


use houseapp\app\request\middlewares\auth\AuthenticationMiddleware;
use housedi\ContainerInterface;
use houseframework\app\config\ConfigInterface;
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
        $globalMiddlewares = [];
        $middlewares = [];
        $skippedActions = [];
        /**
         * @var ConfigInterface $config
         */
        $config = $container->get('application.config');
        if ($config->get('auth')) {
            $authMiddleware = new AuthenticationMiddleware(
                $container->get('application.entityManager')->getMapper('User')
            );
            $container->set(AuthenticationMiddleware::class, $authMiddleware);
            $globalMiddlewares[] = AuthenticationMiddleware::class;
        }
        $pipelineBuilder = new PipelineBuilder($container, $globalMiddlewares, $middlewares, $skippedActions);
        $container->set(PipelineBuilderInterface::class, $pipelineBuilder);
    }
}
