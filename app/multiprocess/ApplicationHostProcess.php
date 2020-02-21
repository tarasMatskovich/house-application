<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 18.02.2020
 * Time: 12:33
 */

namespace houseapp\app\multiprocess;


use houseframework\app\config\ConfigInterface;
use houseframework\app\eventlistener\EventListenerInterface;
use houseframework\app\process\payload\PayloadKeysEnum;
use houseframework\app\router\RouterInterface;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use Thruway\ClientSession;
use Thruway\Peer\Client;
use Thruway\Transport\PawlTransportProvider;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Factory;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Payload;
use WyriHaximus\React\ChildProcess\Pool\PoolInterface;
use WyriHaximus\React\ChildProcess\Pool\WorkerInterface;

/**
 * Class ApplicationHostProcess
 * @package houseapp\app\multiprocess
 */
class ApplicationHostProcess implements ApplicationHostProcessInterface
{

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var EventListenerInterface
     */
    private $eventListener;

    /**
     * @var PoolInterface
     */
    private $pool;

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $actions;

    /**
     * ApplicationHostProcess constructor.
     * @param ConfigInterface $config
     * @param RouterInterface $router
     * @param EventListenerInterface $eventListener
     * @param PoolInterface $pool
     * @param LoopInterface $loop
     * @param array $options
     */
    public function __construct(
        ConfigInterface $config,
        RouterInterface $router,
        EventListenerInterface $eventListener,
        PoolInterface $pool,
        LoopInterface $loop,
        array $options = []
    )
    {
        $this->config = $config;
        $this->router = $router;
        $this->eventListener = $eventListener;
        $this->pool = $pool;
        $this->loop= $loop;
        $this->options = $options;
        $this->pool->on('worker', function (WorkerInterface $worker) use ($options) {
            $worker->rpc(Factory::rpc(
                ApplicationSubProcess::RPC_BUILD,
                [
                    ApplicationSubProcess::CONFIG => $options,
                    ApplicationSubProcess::APP_CONFIG => json_encode($this->config)
                ]
            ));
        });
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function start()
    {
        $this->actions = $this->router->getRoutes();
        $realm = $this->config->get("transport:wamp:realm");
        $url = $this->config->get("transport:wamp:url");
        $client = new Client($realm, $this->loop);
        $client->addTransportProvider(new PawlTransportProvider($url));
        $client->on('open', function (ClientSession $session) {
            $this->registerActions($session);
            $this->registerListeners($session);
        });
        $client->start();
    }

    /**
     * @param ClientSession $session
     */
    private function registerActions(ClientSession $session)
    {
        foreach ($this->actions as $key => $action) {
            $session->register($key, function ($arguments) use ($action) {
                $result = $this->run($action, $arguments);
                return $result;
            });
        }
    }

    /**
     * @param ClientSession $session
     */
    private function registerListeners(ClientSession $session)
    {
        $channels = $this->eventListener->getChannels();
        foreach ($channels as $channelKey => $channelValue) {
            $listener = $channelValue;
            $session->subscribe($channelKey, function ($arguments) use ($listener) {
                return $this->run($listener, $arguments);
            });
        }
    }



    /**
     * @param string $action
     * @param $attributes
     * @return PromiseInterface
     */
    public function run(string $action, $attributes)
    {
        $attributesFromArguments = $attributes[0] ?? null;
        $attributes = [];
        if ($attributesFromArguments) {
            if (is_string($attributesFromArguments)) {
                $attributes = json_decode($attributesFromArguments, null);
            } else {
                $attributes = (array)$attributesFromArguments;
            }
        }
        return $this->pool->rpc(Factory::rpc(
            ApplicationSubProcess::RPC_RUN,
            [
                PayloadKeysEnum::ACTION => $action,
                PayloadKeysEnum::ATTRIBUTES => json_encode($attributes)
            ])
        )->then(function (Payload $payload) {
            return $payload->getPayload();
        });
    }
}
