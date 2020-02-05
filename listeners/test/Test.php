<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 12:01
 */

namespace houseapp\listeners\test;


use houseframework\listener\ListenerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Test
 * @package houseapp\listeners\test
 */
class Test implements ListenerInterface
{

    /**
     * @param ServerRequestInterface $request
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request)
    {
        echo 123;
        return [];
    }
}
