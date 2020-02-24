<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 11:35
 */

namespace bootstrap\scripts;


use housedi\ContainerInterface;

/**
 * Interface BootstrapScriptInterface
 * @package bootstrap\scripts
 */
interface BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container);

}
