<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:03
 */

namespace houseapp\app\entities\User;


use houseorm\mapper\annotations\Gateway;
use houseorm\mapper\annotations\Field;

/**
 * Class User
 * @package house\Entities\User
 * @Gateway(type="datatable.users")
 */
class User implements UserInterface
{

    /**
     * @var int
     * @Field(map="id")
     */
    private $id;

    /**
     * @var null|string
     * @Field(map="name")
     */
    private $name;

    /**
     * @var null|string
     * @Field(map="email")
     */
    private $email;

    /**
     * @var null|string
     * @Field(map="password")
     */
    private $password;

    /**
     * User constructor.
     * @param null $name
     * @param null $email
     * @param null $password
     */
    public function __construct($name = null, $email = null, $password = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
