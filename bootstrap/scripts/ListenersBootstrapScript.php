<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 12:02
 */

namespace houseapp\bootstrap\scripts;


use houseapp\listeners\test\Test;
use housedi\ContainerInterface;


/**
 * Class ListenersBootstrapScript
 * @package houseapp\bootstrap\scripts
 */
class ListenersBootstrapScript implements BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container)
    {
        $container->set('listener.test', Test::class);
    }
}
