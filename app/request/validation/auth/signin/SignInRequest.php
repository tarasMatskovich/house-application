<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 06.02.2020
 * Time: 19:43
 */

namespace app\request\validation\auth\signin;


use houseframework\app\request\ValidatedRequestMessage;

/**
 * Class SignInRequest
 * @package app\request\validation\auth\signin
 */
class SignInRequest extends ValidatedRequestMessage
{

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'email' => 'required',
            'password' => ['required', 'max:255', 'min:3']
        ];
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return [];
    }
}
