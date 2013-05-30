<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 27-05-13
 * Time: 12:05
 * To change this template use File | Settings | File Templates.
 */

require_once MODEL_ROOT . 'NotificationArea_Model.php';

class Main_Model
{
    /**
     * @var
     */

    /**
     * @var NotificationArea_Model
     */
    public $notification;

    /**
     *
     */
    public function __construct()
    {
        $this->notification = new NotificationArea_Model();
    }
}