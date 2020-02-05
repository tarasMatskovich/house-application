<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 11:43
 */

namespace houseapp\bootstrap\scripts;


use houseapp\app\entities\User\User;
use houseapp\app\repositories\UserRepository\UserRepository;
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
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \houseorm\config\ConfigException
     * @throws \houseorm\mapper\DomainMapperException
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
        $entityManager->setMapper(
            'User',
            new UserRepository(User::class)
            );
        // Add your repositories here
        $container->set('application.entityManager', $entityManager);
    }
}
