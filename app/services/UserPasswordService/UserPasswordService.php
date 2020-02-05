<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:51
 */

namespace houseapp\app\services\UserPasswordService;


use houseapp\app\entities\User\UserInterface;

/**
 * Class UserPasswordService
 * @package houseapp\app\services\UserPasswordService
 */
class UserPasswordService implements UserPasswordServiceInterface
{

    /**
     * @param string $password
     * @return string
     */
    public function generateHash(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param UserInterface $user
     * @param string $password
     * @return bool
     */
    public function checkPassword(UserInterface $user, string $password)
    {
        return password_verify($password, $user->getPassword());
    }
}
