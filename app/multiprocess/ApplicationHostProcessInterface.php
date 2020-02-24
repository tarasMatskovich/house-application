<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 18.02.2020
 * Time: 12:32
 */

namespace app\multiprocess;


use React\Promise\PromiseInterface;

/**
 * Interface ApplicationHostProcessInterface
 * @package app\multiprocess
 */
interface ApplicationHostProcessInterface
{

    /**
     * @return void
     */
    public function start();

    /**
     * @param string $action
     * @param $attributes
     * @return PromiseInterface
     */
    public function run(string $action, $attributes);

}
