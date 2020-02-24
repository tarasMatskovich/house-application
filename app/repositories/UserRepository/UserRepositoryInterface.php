<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:06
 */

namespace app\repositories\UserRepository;


use app\entities\User\UserInterface;
use houseorm\mapper\DomainMapperInterface;

/**
 * Interface UserRepositoryInterface
 * @package app\repositories\UserRepository
 */
interface UserRepositoryInterface extends DomainMapperInterface
{

    /**
     * @param $id
     * @return UserInterface|null
     */
    public function find($id);

    /**
     * @param array $criteria
     * @return UserInterface|null
     */
    public function findOneBy($criteria);

}
