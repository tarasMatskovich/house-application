<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 11:39
 */

namespace bootstrap\scripts;


use housedi\ContainerInterface;


/**
 * Class ServicesBootstrapScript
 * @package bootstrap\scripts
 */
class ServicesBootstrapScript implements BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container)
    {
        // REGISTER YOUR SERVICES IN CONTAINER HERE
    }
}
