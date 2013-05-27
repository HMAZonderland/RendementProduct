<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 26-05-13
 * Time: 16:54
 * Debug class used for debugging. Can be used to output strings or to view objects/arrays
 */

/**
 * Class Debug
 */
class Debug
{
    /**
     * When OUTPUT_DEBUG is true (see bootstrap.php) it will output the string
     * @param string $s
     */
    public static function s($s)
    {
        if (OUTPUT_DEBUG) {
            echo $s . "<br />";
        }
    }

    /**
     * When OUTPUT_DEBUG is true (see bootstrap.php) it will output the object or array send
     * @param Object|array $a
     */
    public static function p($a)
    {
        if (OUTPUT_DEBUG) {
            echo "<pre>";
            print_r($a);
            echo "</pre><br />";
        }
    }
}