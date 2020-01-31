<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:29
 */

namespace houseapp\bootstrap\scripts;


use houseapp\actions\test\Test;
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
    }
}
