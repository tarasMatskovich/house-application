<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 11:16
 */

namespace app\services\Authentication\Authenticator\Factory;


use app\services\Authentication\AuthenticationTypes;
use app\services\Authentication\Authenticator\AuthenticatorInterface;


/**
 * Class AuthenticatorFactory
 * @package app\services\Authentication\Authenticator\Factory
 */
class AuthenticatorFactory implements AuthenticatorFactoryInterface
{

    /**
     * @var AuthenticatorInterface
     */
    private $jwtAuthenticator;

    /**
     * AuthenticatorFactory constructor.
     * @param AuthenticatorInterface $jwtAuthenticator
     */
    public function __construct(
        AuthenticatorInterface $jwtAuthenticator
    )
    {
        $this->jwtAuthenticator = $jwtAuthenticator;
    }

    /**
     * @param string $authType
     * @return AuthenticatorInterface
     */
    public function makeAuthenticator(?string $authType = null)
    {
        if (!$authType) {
            $authType = AuthenticationTypes::JWT_AUTH_TYPE;
        }
        switch ($authType) {
            case AuthenticationTypes::JWT_AUTH_TYPE:
            default:
                return $this->jwtAuthenticator;
                break;
        }
    }
}
