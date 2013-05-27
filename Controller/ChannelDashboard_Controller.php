<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 18:59
 * To change this template use File | Settings | File Templates.
 */

require_once DOCUMENT_ROOT . 'Model/ChannelDashboard_Model.php';

/**
 * Class ChannelDashboard
 */
class ChannelDashboard_Controller extends View_Controller
{
    /**
     * @var ChannelDashboardModel
     */
    public $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new ChannelDashboard_Model();
    }

    /**
     *
     */
    public function index()
    {
        return $this->parse();
    }
}