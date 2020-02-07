<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 11:12
 */

namespace houseapp\app\services\Authentication\Authenticator;


use houseapp\app\entities\User\UserInterface;
use houseapp\app\services\Authentication\AuthenticationPayload\AuthenticationPayloadInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface AuthenticatorInterface
 * @package houseapp\app\services\Authentication\Authenticator
 */
interface AuthenticatorInterface
{

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function auth(ServerRequestInterface $request);

    /**
     * @param UserInterface $user
     * @return AuthenticationPayloadInterface
     */
    public function getAuthPayload(UserInterface $user);

}
