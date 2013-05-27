<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 26-05-13
 * Time: 16:54
 * To change this template use File | Settings | File Templates.
 */
class Debug
{
    public static function s($s)
    {
        if (OUTPUT_DEBUG) echo $s . "<br />";
    }

    public static function p($a)
    {
        if (OUTPUT_DEBUG)
        {
            echo "<pre>";
            print_r($a);
            echo "</pre><br />";
        }
    }
}