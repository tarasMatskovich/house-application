<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 15:52
 */

namespace app\responders\UserResponder;


use app\entities\User\UserInterface;

/**
 * Interface UserResponderInterface
 * @package app\responders
 */
interface UserResponderInterface
{

    /**
     * @param UserInterface $user
     * @return array
     */
    public function respond(UserInterface $user);

}
