<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 17:29
 * This class is used for various Google (OAuth) functions.
 * It fetches an access token and refreshes the exsisting refresh token.
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