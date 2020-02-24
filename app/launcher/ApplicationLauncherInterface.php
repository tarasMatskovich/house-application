<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 30.01.2020
 * Time: 17:43
 */

namespace app\launcher;


interface ApplicationLauncherInterface
{

    /**
     * @param array $options
     * @return void
     */
    public function launch(array $options = []);

}
