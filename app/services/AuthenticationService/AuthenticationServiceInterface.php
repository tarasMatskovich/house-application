<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:45
 */

namespace houseapp\app\services\AuthenticationService;


use houseapp\app\entities\User\UserInterface;

/**
 * Interface AuthenticationServiceInterface
 * @package houseapp\app\services\AuthenticationService
 */
interface AuthenticationServiceInterface
{

    /**
     * @param UserInterface $user
     * @return string
     */
    public function createToken(UserInterface $user);

    /**
     * @param string $token
     * @return bool
     */
    public function checkToken(string $token);

    /**
     * @param UserInterface $user
     * @param string $password
     * @return bool
     */
    public function verifyUser(UserInterface $user, string $password);

}
