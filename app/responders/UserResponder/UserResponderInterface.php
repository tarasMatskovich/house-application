<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 15:52
 */

namespace houseapp\app\responders\UserResponder;


use houseapp\app\entities\User\UserInterface;

/**
 * Interface UserResponderInterface
 * @package houseapp\app\responders
 */
interface UserResponderInterface
{

    /**
     * @param UserInterface $user
     * @return array
     */
    public function respond(UserInterface $user);

}
