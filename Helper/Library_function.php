<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 26-05-13
 * Time: 16:08
 * To change this template use File | Settings | File Templates.
 */

class Library
{
    public static function load($lib)
    {
        $library = unserialize(LIBRARY);
        $location = $library[$lib];
        require_once $location;
    }
}