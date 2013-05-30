<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 23-05-13
 * Time: 17:40
 * View Controller parses all models and loads the required views
 */

require_once MODEL_ROOT . 'NotificationArea_Model.php';

/**
 * Class View_Controller
 */
class View_Controller
{
    /**
     * The controller to cal;
     * @var
     */
    private $controller;

    /**
     * Action/Method (view) to load
     * @var
     */
    private $action;

    /**
     * @var
     */
    private $model;

    /**
     * @var NotificationArea_Model
     */
    private $notification;

    /**
     * @param $model
     */
    public function parse($model = null)
    {
        $this->model = $model;
        if (isset($this->model->notification)) {
            $this->notification = $model->notification;
        } else {
            $this->notification = new NotificationArea_Model();
        }

        $debug = debug_backtrace();
        $this->controller = $debug[1]['class'];
        $this->action = $debug[1]['function'];

        // Load main template
        include SHARED_ROOT . '_layout.html.php';
    }

    /**
     * @param $controller
     * @param $action
     *
     * @return null|string
     */
    public function renderView()
    {
        $filepath = VIEW_ROOT . $this->controller . '/' . $this->action . '.html.php';
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