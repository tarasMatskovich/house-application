<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 11:39
 */

namespace houseapp\bootstrap\scripts;


use houseapp\app\services\TestService\TestService;
use houseapp\app\services\TestService\TestServiceInterface;
use housedi\ContainerInterface;


/**
 * Class ServicesBootstrapScript
 * @package houseapp\bootstrap\scripts
 */
class ServicesBootstrapScript implements BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container)
    {
        $container->set(TestServiceInterface::class, TestService::class);
    }
}
