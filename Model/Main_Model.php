<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 27-05-13
 * Time: 12:05
 * To change this template use File | Settings | File Templates.
 */

require_once MODEL_ROOT . 'NotificationArea_Model.php';
require_once MODEL_ROOT . 'Navigation_Model.php';

class Main_Model {
    /**
     * @var
     */
    public $navigation;

    /**
     * @var NotificationArea_Model
     */
    public $notification;

    /**
     * @var bool|string
     */
    public $from;

    /**
     * @var bool|string
     */
    public $to;

    public function __construct() {
        $this->navigation = new Navigation_Model();
        $this->notification = new NotificationArea_Model();

        /**
         * Add scope, when there is no cookie, create it and set it default to 7.
         */
        if (isset($_COOKIE['scope']) && !empty($_COOKIE['scope'])) {
            $scope = $_COOKIE['scope'];
        } else {
            $scope = 7;
            setcookie('scope', $scope, time() + 60 * 60 * 24 * 365 * 20, '/');
        }
        $this->from = date('Y-m-d', time() - $scope * 24 * 60 * 60);
        $this->to = date('Y-m-d H:i:s', time());
    }
}