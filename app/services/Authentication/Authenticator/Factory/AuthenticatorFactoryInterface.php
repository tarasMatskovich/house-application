<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 11:15
 */

namespace houseapp\app\services\Authentication\Authenticator\Factory;


use houseapp\app\services\Authentication\Authenticator\AuthenticatorInterface;

/**
 * Interface AuthenticatorFactoryInterface
 * @package houseapp\app\services\Authentication\Authenticator\Factory
 */
interface AuthenticatorFactoryInterface
{

    /**
     * @param string $authType
     * @return AuthenticatorInterface
     */
    public function makeAuthenticator(?string $authType = null);

}
