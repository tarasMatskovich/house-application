<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 06.02.2020
 * Time: 18:28
 */

namespace houseapp\app\request\validation\auth\signup;


use houseframework\app\request\ValidatedRequestMessage;

/**
 * Class AuthRequest
 * @package houseapp\app\request\validation
 */
class SignUpRequest extends ValidatedRequestMessage
{

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return [

        ];
    }
}
