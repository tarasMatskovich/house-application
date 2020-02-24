<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 14:48
 */

namespace app\request\middlewares\auth\factory;


use app\request\middlewares\auth\AuthenticationMiddlewareInterface;
use app\services\Authentication\AuthenticationTypes;


/**
 * Class AuthenticationMiddlewareFactory
 * @package app\request\middlewares\auth\factory
 */
class AuthenticationMiddlewareFactory implements AuthenticationMiddlewareFactoryInterface
{

    /**
     * @var AuthenticationMiddlewareInterface
     */
    private $jwtAuthenticationMiddleware;

    /**
     * AuthenticationMiddlewareFactory constructor.
     * @param AuthenticationMiddlewareInterface $jwtAuthenticationMiddleware
     */
    public function __construct(
        AuthenticationMiddlewareInterface $jwtAuthenticationMiddleware
    )
    {
        $this->jwtAuthenticationMiddleware = $jwtAuthenticationMiddleware;
    }

    /**
     * @param string|null $authType
     * @return AuthenticationMiddlewareInterface
     */
    public function makeAuthenticationMiddleware(?string $authType = null)
    {
        if (!$authType) {
            $authType = AuthenticationTypes::JWT_AUTH_TYPE;
        }
        switch ($authType) {
            case AuthenticationTypes::JWT_AUTH_TYPE:
            default:
                return $this->jwtAuthenticationMiddleware;
                break;
        }
    }
}
