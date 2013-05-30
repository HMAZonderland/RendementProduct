<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 30-05-13
 * Time: 11:30
 * To change this template use File | Settings | File Templates.
 */

class NotificationArea_Model
{
    public $notification_type;
    public $notification_msg;

    public function has()
    {
        return (!empty($this->notification_msg) && !empty($this->notification_type));
    }

    /**
     * Sets an error msg
     * @param $msg
     */
    public function error($msg)
    {
        $this->notification_type = 'erorr';
        $this->notification_msg = $msg;
    }

    /**
     * Sets an information msg
     * @param $msg
     */
    public function information($msg)
    {
        $this->notification_type = 'information';
        $this->notification_msg = $msg;
    }

    /**
     * Sets a warning msg
     * @param $msg
     */
    public function warning($msg)
    {
        $this->notification_type = 'warning';
        $this->notification_msg = $msg;
    }

    /**
     * Sets a success msg
     * @param $msg
     */
    public function success($msg)
    {
        $this->notification_type = 'success';
        $this->notification_msg = $msg;
    }
}