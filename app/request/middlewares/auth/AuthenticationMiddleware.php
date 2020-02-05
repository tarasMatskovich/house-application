<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 11:26
 */

namespace houseapp\app\request\middlewares\auth;


use houseapp\app\repositories\UserRepository\UserRepositoryInterface;
use houseframework\app\request\middleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthenticationMiddleware
 * @package houseapp\app\request\middlewares\auth
 */
class AuthenticationMiddleware implements MiddlewareInterface
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * AuthenticationMiddleware constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return $request;
    }
}
