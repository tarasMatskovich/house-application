<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:29
 */

namespace houseapp\bootstrap\scripts;


use houseapp\actions\auth\signin\SignIn;
use houseapp\actions\auth\signup\SignUp;
use houseapp\actions\test\Test;
use houseapp\app\factories\UserFactory\UserFactoryInterface;
use houseapp\app\responders\UserResponder\UserResponderInterface;
use houseapp\app\services\Authentication\Authenticator\Factory\AuthenticatorFactoryInterface;
use houseapp\app\services\UserPasswordService\UserPasswordServiceInterface;
use housedi\ContainerInterface;


/**
 * Class ActionsBootstrapScripts
 * @package houseapp\bootstrap\scripts
 */
class ActionsBootstrapScripts implements BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container)
    {
        $container->set('action.test', Test::class);
        if ($container->get('application.config')->get('auth:use')) {
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
}
