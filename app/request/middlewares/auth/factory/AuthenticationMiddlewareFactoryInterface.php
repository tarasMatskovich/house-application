<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 14:47
 */

namespace app\request\middlewares\auth\factory;


use app\request\middlewares\auth\AuthenticationMiddlewareInterface;

/**
 * Interface AuthenticationMiddlewareFactoryInterface
 * @package app\request\middlewares\auth\factory
 */
interface AuthenticationMiddlewareFactoryInterface
{

    /**
     * @param string|null $authType
     * @return AuthenticationMiddlewareInterface
     */
    public function makeAuthenticationMiddleware(?string $authType = null);

}
