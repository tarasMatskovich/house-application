<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 17.02.2020
 * Time: 14:51
 */

namespace app\launcher;


use app\multiprocess\ApplicationHostProcess;
use app\multiprocess\ApplicationSubProcess;
use houseframework\app\config\ConfigInterface;
use houseframework\app\eventlistener\EventListenerInterface;
use houseframework\app\router\factory\RouterFactoryInterface;
use React\EventLoop\Factory;
use WyriHaximus\React\ChildProcess\Pool\Factory\Flexible;
use WyriHaximus\React\ChildProcess\Pool\PoolInterface;

/**
 * Class MultiProcessApplicationLauncher
 * @package app\launcher
 */
class MultiProcessApplicationLauncher implements ApplicationLauncherInterface
{

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var RouterFactoryInterface
     */
    private $routerFactory;

    /**
     * @var EventListenerInterface
     */
    private $eventListener;

    /**
     * @var string
     */
    private $appKey;

    /**
     * MultiProcessApplicationLauncher constructor.
     * @param ConfigInterface $config
     * @param RouterFactoryInterface $routerFactory
     * @param EventListenerInterface $eventListener
     * @param string $appKey
     */
    public function __construct(
        ConfigInterface $config,
        RouterFactoryInterface $routerFactory,
        EventListenerInterface $eventListener,
        string $appKey
    )
    {
        $this->config = $config;
        $this->routerFactory = $routerFactory;
        $this->eventListener = $eventListener;
        $this->appKey = $appKey;
    }

    /**
     * @param array $options
     * @return void
     */
    public function launch(array $options = [])
    {
        $loop = Factory::create();
        Flexible::createFromClass(ApplicationSubProcess::class, $loop, $options)->then(function (PoolInterface $pool) use ($loop, $options) {
            $applicationHostProcess = new ApplicationHostProcess(
                $this->config,
                $this->routerFactory->make($this->appKey),
                $this->eventListener,
                $pool,
                $loop,
                $options
            );
            $applicationHostProcess->start();
        });
        $loop->run();
    }
}
