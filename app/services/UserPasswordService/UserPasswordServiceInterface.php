<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:51
 */

namespace app\services\UserPasswordService;


use app\entities\User\UserInterface;

/**
 * Interface UserPasswordServiceInterface
 * @package app\services\UserPasswordService
 */
interface UserPasswordServiceInterface
{

    /**
     * @param string $password
     * @return string
     */
    public function generateHash(string $password);

    /**
     * @param UserInterface $user
     * @param string $password
     * @return bool
     */
    public function checkPassword(UserInterface $user, string $password);

}
