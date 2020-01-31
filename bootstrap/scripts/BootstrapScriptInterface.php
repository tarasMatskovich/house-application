<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 11:35
 */

namespace houseapp\bootstrap\scripts;


use housedi\ContainerInterface;

/**
 * Interface BootstrapScriptInterface
 * @package houseapp\bootstrap\scripts
 */
interface BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container);

}
