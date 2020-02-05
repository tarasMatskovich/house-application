<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 11:26
 */

namespace houseapp\app\request\middlewares\auth;


use houseapp\app\services\AuthenticationService\AuthenticationServiceInterface;
use houseframework\app\request\middleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthenticationMiddleware
 * @package houseapp\app\request\middlewares\auth
 */
class AuthenticationMiddleware implements MiddlewareInterface
{

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * AuthenticationMiddleware constructor.
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function __construct(
        AuthenticationServiceInterface $authenticationService
    )
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     * @throws AuthenticationException
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $token = $request->getAttribute('token');
        if (!$token) {
            throw new AuthenticationException("Parameter `_token` is missing in request");
        }
        if (!$this->authenticationService->checkToken($token)) {
            throw new AuthenticationException("Authentication token is wrong");
        }
        return $request;
    }
}
