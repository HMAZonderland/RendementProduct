<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:16
 * To change this template use File | Settings | File Templates.
 */
require_once DOCUMENT_ROOT . '/Controller/Template_Controller.php';

/**
 * Class Controller
 */
class Main_Controller
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @param $controllername
     * @param $action
     * @param $params
     */
    public function __construct($controllername, $action, $params)
    {
        $controller = $this->loadController($controllername);

        if ($this->hasView($controllername, $action))
        {
            $model = $controller->model;
            $args = get_object_vars($model);
            $this->template = new Template($this->loadView($controllername, $action), $args);
        }
    }

    /**
     * Includes the needed controller and creates an instance of this controller
     *
     * @param $controller
     *
     * @return mixed
     */
    private function loadController($controller)
    {
        // Load the class needed
        include DOCUMENT_ROOT . '/Controller/' . $controller . "_Controller.php";

        // Create an instance of this class
        return $this->createInstance($controller);
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
        return $controller = new $controller;
    }

    /**
     * Verifies if the needed view actually exsists
     *
     * @param $controller
     * @param $action
     *
     * @return bool
     */
    private function hasView($controller, $action)
    {
        return ($this->loadView($controller, $action) != null);
    }

    /**
     * Returns the filepath when the needed view exsists.
     *
     * @param $controller
     * @param $action
     *
     * @return null|string
     */
    private function loadView($controller, $action)
    {
        $filepath = DOCUMENT_ROOT . '/View/' . $controller . '/' . $action . '.html.php';
        if (file_exists($filepath))
        {
            return $filepath;
        }
        return null;
    }

    /**
     * Renders the page using the Template render function.
     */
    public function render()
    {
        $this->template->render();
    }
}