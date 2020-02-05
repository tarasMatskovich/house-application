<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 11:43
 */

namespace houseapp\bootstrap\scripts;


use housedi\ContainerInterface;
use houseorm\Cache\Config\CacheConfig;
use houseorm\config\Config;
use houseframework\app\config\ConfigInterface as ApplicationConfigInterface;
use houseorm\EntityManager;


/**
 * Class EntityManagerBootstrapScript
 * @package houseapp\bootstrap\scripts
 */
class EntityManagerBootstrapScript implements BootstrapScriptInterface
{

    /**
     * @param ContainerInterface $container
     * @return void
     * @throws \houseorm\config\ConfigException
     */
    public function boot(ContainerInterface $container)
    {
        /**
         * @var ApplicationConfigInterface $config
         */
        $config = $container->get('application.config');
        $entityManagerConfig = new Config($config->get('database'));
        $cache = $config->get('database.cache');
        if ($cache) {
            $entityManagerConfig->setCacheConfig(new CacheConfig($cache));
        }
        $entityManager = new EntityManager($entityManagerConfig);
        $container->set('application.entityManager', $entityManager);
    }
}
