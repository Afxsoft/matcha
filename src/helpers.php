<?php
/**
 * Created by PhpStorm.
 * User: aouloube
 * Date: 10/4/16
 * Time: 5:08 PM
 */

/**
 * This funciton return the url of route name
 * @param $app
 * @param string $path
 * @param array $param
 * @return mixed
 */
function path($app, $path = '', $param = array()){
    return $app->getContainer()->get('router')->pathFor($path, $param);
}

/**
 * This function render string with htmlentities traitement
 * @param string $string
 */
function render($string = '')
{
    echo htmlentities($string);
}