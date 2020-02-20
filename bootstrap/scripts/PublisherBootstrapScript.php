<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 17:31
 */

namespace houseapp\bootstrap\scripts;


use housedi\ContainerInterface;
use houseframework\app\publisher\DelayedWampPublisher;
use houseframework\app\publisher\factory\PublisherFactory;
use houseframework\app\publisher\factory\PublisherFactoryInterface;
use houseframework\app\publisher\WampPublisher;
use Psr\Log\NullLogger;
use Thruway\Logging\Logger;
use Thruway\Peer\Client;
use Thruway\Transport\PawlTransportProvider;


/**
 * Class PublisherBootstrapScript
 * @package houseapp\bootstrap\scripts
 */
class PublisherBootstrapScript implements BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container)
    {
        $container->set('application.publisher.wamp', function (ContainerInterface $container) {
            $clientSession = null;
            try {
                $clientSession = $container->get('application.clientSession');
                $publisher = new WampPublisher($clientSession);
            } catch (\Exception $e) {
                $realm = $container->get('application.config')->get("transport:wamp:realm");
                $url = $container->get('application.config')->get("transport:wamp:url");
                Logger::set(new NullLogger());
                $client = new Client($realm);
                $client->addTransportProvider(new PawlTransportProvider($url));
                $publisher = new DelayedWampPublisher($client);
            }
            return $publisher;
        });
        $container->set(PublisherFactoryInterface::class, function (ContainerInterface $container) {
            return new PublisherFactory(
                $container->get('application.publisher.wamp')
            );
        });

    }

}
