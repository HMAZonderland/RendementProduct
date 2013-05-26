<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 23-05-13
 * Time: 17:40
 * To change this template use File | Settings | File Templates.
 */

class View_Controller
{

    private $controller;
    private $action;

    /**
     * @param $model
     */
    public function parse()
    {
        $debug = debug_backtrace();
        $this->controller = $debug[1]['class'];
        $this->action = $debug[1]['function'];

        // Load main template
        include SHARED_ROOT . '/_layout.html.php';
    }

    /**
     * @param $controller
     * @param $action
     *
     * @return null|string
     */
    public function renderView()
    {
        $filepath = VIEW_ROOT . '/' . $this->controller . '/' . $this->action . '.html.php';
        if (file_exists($filepath))
        {
            include $filepath;
        }
        else
        {
            echo "Could not find file: " . $filepath;
        }
    }
}