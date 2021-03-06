<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 11:15
 */

namespace bootstrap\bootstrapper;


/**
 * Interface BootstrapperInterface
 * @package bootstrap\bootstrapper
 */
interface BootstrapperInterface
{

    /**
     * @return array
     */
    public function getBootstrapList();

    /**
     * @param string $bootstrapScriptClassName
     * @return void
     */
    public function addBootstrapScript(string $bootstrapScriptClassName);

}
