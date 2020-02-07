<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:42
 */

namespace houseapp\bootstrap\scripts;


use houseapp\app\request\middlewares\auth\JWTAuthenticationMiddleware;
use houseapp\app\request\middlewares\auth\factory\AuthenticationMiddlewareFactory;
use houseapp\app\request\middlewares\auth\factory\AuthenticationMiddlewareFactoryInterface;
use houseapp\app\services\Authentication\Authenticator\Factory\AuthenticatorFactoryInterface;
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
        if ($config->get('auth:use')) {
            // REGISTER YOUR AUTH MIDDLEWARES HERE
            $container->set(JWTAuthenticationMiddleware::class, function (ContainerInterface $container) {
                /**
                 * @var AuthenticatorFactoryInterface $authenticatorFactory
                 */
                $authenticatorFactory = $container->get(AuthenticatorFactoryInterface::class);
                return new JWTAuthenticationMiddleware(
                    $authenticatorFactory->makeAuthenticator($container->get('application.config')->get('auth.defaultAuthenticator'))
                );
            });

            $container->set(AuthenticationMiddlewareFactoryInterface::class, function (ContainerInterface $container) {
                return new AuthenticationMiddlewareFactory(
                    $container->get(JWTAuthenticationMiddleware::class)
                );
            });
            /**
             * @var AuthenticationMiddlewareFactoryInterface $authenticationMiddlewareFactory
             */
            $authenticationMiddlewareFactory = $container->get(AuthenticationMiddlewareFactoryInterface::class);
            $authenticationMiddleware = $authenticationMiddlewareFactory->makeAuthenticationMiddleware(
                $container->get('application.config')->get('auth.defaultAuthenticator')
            );
            $globalMiddlewares[] = get_class($authenticationMiddleware);
            $skippedActions = array_merge($skippedActions, [
                'action.auth.signin' => [get_class($authenticationMiddleware)],
                'action.auth.signup' => [get_class($authenticationMiddleware)]
            ]);
        }
        $pipelineBuilder = new PipelineBuilder($container, $globalMiddlewares, $middlewares, $skippedActions);
        $container->set(PipelineBuilderInterface::class, $pipelineBuilder);
    }
}
