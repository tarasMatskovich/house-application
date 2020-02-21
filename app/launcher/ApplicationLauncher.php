<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 30.01.2020
 * Time: 17:43
 */

namespace houseapp\app\launcher;


use houseapp\bootstrap\bootstrapper\BootstrapperInterface;
use houseapp\bootstrap\scripts\BootstrapScriptInterface;
use housedi\ContainerInterface;
use houseframework\app\factory\ApplicationFactory;
use houseframework\app\factory\ApplicationFactoryInterface;
use houseframework\app\request\builder\RequestBuilderInterface;
use houseframework\app\request\pipeline\builder\PipelineBuilderInterface;
use houseframework\app\router\factory\RouterFactoryInterface;

/**
 * Class ApplicationLauncher
 * @package app\launcher
 */
class ApplicationLauncher implements ApplicationLauncherInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var RouterFactoryInterface
     */
    private $routerFactory;

    /**
     * @var BootstrapperInterface
     */
    private $bootstrapper;

    /**
     * @var string
     */
    private $buildKey;

    /**
     * ApplicationLauncher constructor.
     * @param ContainerInterface $container
     * @param RouterFactoryInterface $routerFactory
     * @param BootstrapperInterface $bootstrapper
     * @param string $buildKey
     */
    public function __construct(
        ContainerInterface $container,
        RouterFactoryInterface $routerFactory,
        BootstrapperInterface $bootstrapper,
        string $buildKey
    )
    {
        $this->container = $container;
        $this->routerFactory = $routerFactory;
        $this->bootstrapper = $bootstrapper;
        $this->buildKey = $buildKey;
        $this->bootstrap();
    }

    private function bootstrap()
    {
        $bootstrapList = $this->bootstrapper->getBootstrapList();
        foreach ($bootstrapList as $bootstrapScript) {
            /**
             * @var BootstrapScriptInterface $bootstrapScript
             */
            $bootstrapScript = $this->container->get($bootstrapScript);
            $bootstrapScript->boot($this->container);
        }
    }

    /**
     * @param array $options
     * @return void
     */
    public function launch(array $options = [])
    {
        $applicationFactory = $this->createApplicationFactory();
        $app = $applicationFactory->make($this->buildKey);
        $app->run();
    }

    /**
     * @return ApplicationFactoryInterface
     */
    private function createApplicationFactory()
    {
        return new ApplicationFactory(
            $this->container,
            $this->routerFactory->make($this->buildKey),
            $this->container->get(PipelineBuilderInterface::class),
            $this->container->get(RequestBuilderInterface::class),
            $this->container->get('application.config')
        );
    }
}
