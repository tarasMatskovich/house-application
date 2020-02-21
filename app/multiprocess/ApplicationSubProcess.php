<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 18.02.2020
 * Time: 12:38
 */

namespace houseapp\app\multiprocess;


use houseapp\bootstrap\bootstrapper\Bootstrapper;
use houseapp\bootstrap\scripts\BootstrapScriptInterface;
use housedi\Container;
use houseframework\app\config\Config;
use houseframework\app\process\app\SubProcessApplication;
use houseframework\app\process\app\SubProcessApplicationInterface;
use houseframework\app\request\builder\RequestBuilderInterface;
use houseframework\app\request\pipeline\builder\PipelineBuilderInterface;
use React\EventLoop\LoopInterface;
use function React\Promise\resolve;
use WyriHaximus\React\ChildProcess\Messenger\ChildInterface;
use WyriHaximus\React\ChildProcess\Messenger\Messages\Payload;
use WyriHaximus\React\ChildProcess\Messenger\Messenger;

/**
 * Class ApplicationSubProcess
 * @package houseapp\app\multiprocess
 */
class ApplicationSubProcess implements ChildInterface
{

    const CONFIG = 'config';

    const APP_CONFIG = 'appConfig';

    const RPC_RUN = 'run';

    const RPC_BUILD = 'build';

    const RPC_PUBLISH_CLIENT_SESSION = 'publishClientSession';

    /**
     * @var SubProcessApplicationInterface
     */
    private $app;

    /**
     * ApplicationSubProcess constructor.
     * @param Messenger $messenger
     * @param LoopInterface $loop
     */
    public function __construct(Messenger $messenger, LoopInterface $loop)
    {
        $messenger->registerRpc(static::RPC_BUILD, function (Payload $payload) {
            if (!$this->app) {
                $this->app = $this->build($payload);
            }
        });
        $messenger->registerRpc(static::RPC_RUN, function (Payload $payload) {
            return resolve($this->app->run($payload));
        });
    }

    /**
     * @param Payload $payload
     * @return SubProcessApplication
     * @throws \housedi\exceptions\ContainerException
     * @throws \housedi\exceptions\NotFoundException
     */
    private function build(Payload $payload)
    {
        $definitions = [];
        $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'container.php';
        if (file_exists($filename)) {
            $definitions = require $filename;
        }
        $container = new Container($definitions);
        $payload = $payload->getPayload();
        $config = $payload[static::APP_CONFIG] ?? null;
        if ($config) {
            $container->set('application.config', new Config(json_decode($config, true)));
        }
        $bootstrapper = new Bootstrapper();
        foreach ($bootstrapper->getBootstrapList() as $bootstrapScript) {
            /**
             * @var BootstrapScriptInterface $bootstrapScript
             */
            $bootstrapScript = $container->get($bootstrapScript);
            $bootstrapScript->boot($container);
        }
        return new SubProcessApplication(
            $container,
            $container->get(RequestBuilderInterface::class),
            $container->get(PipelineBuilderInterface::class)
        );
    }

    /**
     * @param Messenger $messenger
     * @param LoopInterface $loop
     */
    public static function create(Messenger $messenger, LoopInterface $loop)
    {
        new static($messenger, $loop);
    }
}
