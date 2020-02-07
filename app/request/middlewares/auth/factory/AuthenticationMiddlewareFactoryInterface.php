<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 14:47
 */

namespace houseapp\app\request\middlewares\auth\factory;


use houseapp\app\request\middlewares\auth\AuthenticationMiddlewareInterface;

/**
 * Interface AuthenticationMiddlewareFactoryInterface
 * @package houseapp\app\request\middlewares\auth\factory
 */
interface AuthenticationMiddlewareFactoryInterface
{

    /**
     * @param string|null $authType
     * @return AuthenticationMiddlewareInterface
     */
    public function makeAuthenticationMiddleware(?string $authType = null);

}
