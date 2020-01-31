<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 11:42
 */

namespace houseapp\app\services\TestService;


/**
 * Class TestService
 * @package houseapp\app\services\TestService
 */
class TestService implements TestServiceInterface
{

    /**
     * @return void
     */
    public function do()
    {
        echo 123;
    }
}
