<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:16
 * To change this template use File | Settings | File Templates.
 */

class Controller
{
    private $template;

    public function __construct($controllername, $action, $params)
    {
        $controller = $this->loadController($controllername);

        if ($this->hasView($controller, $action))
        {
            $model = $controller->model;
            $args = get_object_vars($model);
            $this->template = new Template($this->loadView($controller, $action), $args);
        }
    }

    private function loadController($controller)
    {
        // Load the class needed
        include DOCUMENT_ROOT . '/Controller/' . $controller . "_Controller.php";

        // Create an instance of this class
        return $this->createInstance($controller);
    }

    private function createInstance($controller)
    {
        return $controller = new $controller;
    }

    private function hasView($controller, $action)
    {
        return ($this->loadView($controller, $action) != null);
    }

    private function loadView($controller, $action)
    {
        $filepath = DOCUMENT_ROOT . '/View/' . $controller . '/' . $action . '.html.php';
        if (file_exists($filepath))
        {
            return $filepath;
        }
        return null;
    }
}