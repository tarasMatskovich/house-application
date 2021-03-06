<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 11:15
 */

namespace bootstrap\bootstrapper;


use bootstrap\scripts\ActionsBootstrapScripts;
use bootstrap\scripts\EntityManagerBootstrapScript;
use bootstrap\scripts\ListenersBootstrapScript;
use bootstrap\scripts\PipelineBootstrapScript;
use bootstrap\scripts\PublisherBootstrapScript;
use bootstrap\scripts\ServicesBootstrapScript;

/**
 * Class Bootstrapper
 * @package bootstrap\bootstrapper
 */
class Bootstrapper implements BootstrapperInterface
{

    /**
     * @var array
     */
    private $bootstrapList = [
        EntityManagerBootstrapScript::class,
        ServicesBootstrapScript::class,
        PublisherBootstrapScript::class,
        ActionsBootstrapScripts::class,
        ListenersBootstrapScript::class,
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
