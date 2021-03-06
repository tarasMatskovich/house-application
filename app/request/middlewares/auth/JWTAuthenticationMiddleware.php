<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 11:26
 */

namespace app\request\middlewares\auth;


use app\services\Authentication\Authenticator\AuthenticatorInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthenticationMiddleware
 * @package app\request\middlewares\auth
 */
class JWTAuthenticationMiddleware implements AuthenticationMiddlewareInterface
{

    /**
     * @var AuthenticatorInterface
     */
    private $authenticator;

    /**
     * AuthenticationMiddleware constructor.
     * @param AuthenticatorInterface $authenticator
     */
    public function __construct(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
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
            throw new AuthenticationException("Parameter `token` is missing in request");
        }
        if (!$this->authenticator->auth($request)) {
            throw new AuthenticationException("Authentication token is wrong");
        }
        return $request;
    }
}
