<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:16
 * To change this template use File | Settings | File Templates.
 */
require_once DOCUMENT_ROOT . '/Controller/View_Controller.php';

/**
 * Class Controller
 */
class Main_Controller
{
    /**
     * Includes the needed controller and creates an instance of this controller
     *
     * @param $controller
     *
     * @return mixed
     */
    public function loadController($controller)
    {
        // Load the class needed
        $filepath = CONTROLLER_ROOT . $controller . ".php";
        if (file_exists($filepath))
        {
            include $filepath;

            // Create an instance of this class
            return $this->createInstance($controller);
        }
        else
        {
            echo "Could not load requested Controller: " . $filepath . "<br />The controller file was not found.";
            //return false;
            //die();
        }
    }

    /**
     * Creates an instance of the controller
     *
     * @param $controller
     *
     * @return mixed
     */
    private function createInstance($controller)
    {
        return $controller = new $controller();
    }
}