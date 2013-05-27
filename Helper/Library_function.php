<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 26-05-13
 * Time: 16:08
 * Library class, loads a library class
 */

/**
 * Class Library
 */
class Library
{
    /**
     * Loads a library,
     * @param string $lib
     */
    public static function load($lib)
    {
        $library = unserialize(LIBRARY);
        if (array_key_exists($lib, $library))
        {
            $location = $library[$lib];
            if (file_exists($location))
            {
                Debug::s('Loaded: ' . $lib . ' library.');
                include $location;
            }
            else
            {
                echo "Could not load the requested library " . $lib . ".<br />The required file is not found in the Library folder. Please check your mapping!";
                die();
            }
        }
        else
        {
            echo "Could not load the required library<br />Library " . $lib . " does not exsist in the library mapping.";
            die();
        }
    }
}