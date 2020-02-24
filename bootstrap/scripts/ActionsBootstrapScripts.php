<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:29
 */

namespace bootstrap\scripts;


use actions\auth\signin\SignIn;
use actions\auth\signup\SignUp;
use actions\test\Test;
use app\factories\UserFactory\UserFactoryInterface;
use app\responders\UserResponder\UserResponderInterface;
use app\services\Authentication\Authenticator\Factory\AuthenticatorFactoryInterface;
use app\services\UserPasswordService\UserPasswordServiceInterface;
use housedi\ContainerInterface;


/**
 * Class ActionsBootstrapScripts
 * @package bootstrap\scripts
 */
class ActionsBootstrapScripts implements BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container)
    {
        $container->set('action.test', function (ContainerInterface $container) {
            return new Test($container->get('application.publisher.wamp'));
        });
        $container->set('action.auth.signin', function (ContainerInterface $container) {
            /**
             * @var AuthenticatorFactoryInterface $authenticatorFactory
             */
            $authenticatorFactory = $container->get(AuthenticatorFactoryInterface::class);
            return new SignIn(
                $container->get('application.entityManager')->getMapper('User'),
                $container->get(UserResponderInterface::class),
                $container->get(UserPasswordServiceInterface::class),
                $authenticatorFactory->makeAuthenticator(
                    $container->get('application.config')->get('auth.defaultAuthenticator')
                )
            );
        });
        $container->set('action.auth.signup', function (ContainerInterface $container) {
            return new SignUp(
                $container->get(UserFactoryInterface::class),
                $container->get('application.entityManager')->getMapper('User'),
                $container->get(UserResponderInterface::class)
            );
        });
    }
}
