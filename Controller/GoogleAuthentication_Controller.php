<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 17:29
 * To change this template use File | Settings | File Templates.
 */

require_once MODEL_ROOT . 'GoogleAuthentication_Model.php';

class GoogleAuthentication_Controller extends View_Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new GoogleAuthentication_Model;
    }

    /**
     *
     */
    public function checkAuthentication()
    {

    }
}