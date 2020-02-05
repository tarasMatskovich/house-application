<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 05.02.2020
 * Time: 13:53
 */

namespace houseapp\app\services\JWTService;


/**
 * Interface JWTServiceInterface
 * @package houseapp\app\services\JWTService
 */
interface JWTServiceInterface
{

    /**
     * @param array $header
     * @param array $payload
     * @return string
     */
    public function encode(array $header, array $payload);

}
