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
 * Class UserResponder
 * @package houseapp\app\responders
 */
class UserResponder implements UserResponderInterface
{

    /**
     * @param UserInterface $user
     * @return array
     */
    public function respond(UserInterface $user)
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ];
    }
}
