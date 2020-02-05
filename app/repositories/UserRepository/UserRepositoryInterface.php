<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:06
 */

namespace houseapp\app\repositories\UserRepository;


use houseapp\app\entities\User\UserInterface;
use houseorm\mapper\DomainMapperInterface;

/**
 * Interface UserRepositoryInterface
 * @package houseapp\app\repositories\UserRepository
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
