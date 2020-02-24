<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 07.02.2020
 * Time: 11:09
 */

namespace app\services\Authentication\AuthenticationPayload;


/**
 * Class AuthenticationPayload
 * @package app\services\Authentication\AuthenticationPayload
 */
class AuthenticationPayload implements AuthenticationPayloadInterface
{

    /**
     * @var mixed
     */
    private $mainData;

    /**
     * @var mixed
     */
    private $secondaryData;

    /**
     * AuthenticationPayload constructor.
     * @param $mainData
     * @param null $secondaryData
     */
    public function __construct($mainData, $secondaryData = null)
    {
        $this->mainData = $mainData;
        $this->secondaryData = $secondaryData;
    }

    /**
     * @return mixed
     */
    public function getMainData()
    {
        return $this->mainData;
    }

    /**
     * @return mixed
     */
    public function getSecondaryData()
    {
        return $this->secondaryData;
    }
}
