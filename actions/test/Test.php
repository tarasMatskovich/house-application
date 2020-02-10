<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 31.01.2020
 * Time: 12:28
 */

namespace houseapp\actions\test;


use houseframework\action\ActionInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class Test
 * @package houseapp\actions\test
 */
class Test implements ActionInterface
{

    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $attr = $request->getAttribute('test');
        return [
            'foo' => $attr
        ];
    }
}
