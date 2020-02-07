<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 17:31
 */

namespace houseapp\bootstrap\scripts;


use housedi\ContainerInterface;
use houseframework\app\publisher\factory\PublisherFactory;
use houseframework\app\publisher\factory\PublisherFactoryInterface;
use houseframework\app\publisher\WampPublisher;


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
        $container->set(WampPublisher::class, function (ContainerInterface $container) {
            return new WampPublisher($container->get('application.clientSession'));
        });
        $container->set(PublisherFactoryInterface::class, function (ContainerInterface $container) {
            return new PublisherFactory(
                $container->get(WampPublisher::class)
            );
        });
    }
}
