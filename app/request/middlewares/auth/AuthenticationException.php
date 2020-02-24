<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 17:45
 */

namespace app\request\middlewares\auth;


use Throwable;

/**
 * Class AuthenticationException
 * @package app\request\middlewares\auth
 */
class AuthenticationException extends \Exception
{

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        $message = "Authentication error: " . $message;
        parent::__construct($message, $code, $previous);
    }

}
