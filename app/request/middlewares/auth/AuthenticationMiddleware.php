<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 11:26
 */

namespace houseapp\app\request\middlewares\auth;


use houseframework\app\request\middleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthenticationMiddleware
 * @package houseapp\app\request\middlewares\auth
 */
class AuthenticationMiddleware implements MiddlewareInterface
{

    public function __invoke(ServerRequestInterface $request)
    {
        // TODO: Implement __invoke() method.
    }
}
