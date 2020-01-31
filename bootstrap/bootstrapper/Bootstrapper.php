<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 11:15
 */

namespace houseapp\bootstrap\bootstrapper;


use houseapp\bootstrap\scripts\ActionsBootstrapScripts;
use houseapp\bootstrap\scripts\PipelineBootstrapScript;
use houseapp\bootstrap\scripts\ServicesBootstrapScript;

/**
 * Class Bootstrapper
 * @package houseapp\bootstrap\bootstrapper
 */
class Bootstrapper implements BootstrapperInterface
{

    /**
     * @var array
     */
    private $bootstrapList = [
        ServicesBootstrapScript::class,
        ActionsBootstrapScripts::class,
        PipelineBootstrapScript::class
    ];

    /**
     * Bootstrapper constructor.
     * @param array $bootstrapList
     */
    public function __construct(array $bootstrapList = [])
    {
        $this->bootstrapList = array_merge($this->bootstrapList, $bootstrapList);
    }

    /**
     * @return array
     */
    public function getBootstrapList()
    {
        return $this->bootstrapList;
    }

    /**
     * @param string $bootstrapScriptClassName
     */
    public function addBootstrapScript(string $bootstrapScriptClassName)
    {
        $this->bootstrapList[] = $bootstrapScriptClassName;
    }
}
