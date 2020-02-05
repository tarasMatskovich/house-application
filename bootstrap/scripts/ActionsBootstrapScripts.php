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
use houseapp\app\services\AuthenticationService\AuthenticationServiceInterface;
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
        $container->set('action.auth.signin', function (ContainerInterface $container) {
            return new SignIn(
                $container->get('application.entityManager')->getMapper('User'),
                $container->get(AuthenticationServiceInterface::class),
                $container->get(UserResponderInterface::class)
            );
        });
        $container->set('action.auth.signup', function (ContainerInterface $container) {
            return new SignUp(
                $container->get(UserFactoryInterface::class),
                $container->get('application.entityManager')->getMapper('User'),
                $container->get(AuthenticationServiceInterface::class),
                $container->get(UserResponderInterface::class)
            );
        });
    }
}
