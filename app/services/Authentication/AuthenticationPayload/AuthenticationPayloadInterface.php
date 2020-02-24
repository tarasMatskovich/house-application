<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 11:08
 */

namespace app\services\Authentication\AuthenticationPayload;


/**
 * Interface AuthenticationPayloadInterface
 * @package app\services\Authentication\AuthenticationPayload
 */
interface AuthenticationPayloadInterface
{

    /**
     * @return mixed
     */
    public function getMainData();

    /**
     * @return mixed
     */
    public function getSecondaryData();

}
