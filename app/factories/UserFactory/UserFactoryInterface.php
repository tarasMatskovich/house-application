<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 14:55
 */

namespace app\factories\UserFactory;


use app\entities\User\UserInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface UserFactoryInterface
 * @package app\factories\UserFactory
 */
interface UserFactoryInterface
{

    /**
     * @param ServerRequestInterface $request
     * @return UserInterface|null
     */
    public function makeUserFromSignInRequest(ServerRequestInterface $request);

    /**
     * @param ServerRequestInterface $request
     * @return UserInterface
     */
    public function makeUserFromSignUpRequest(ServerRequestInterface $request);

}
