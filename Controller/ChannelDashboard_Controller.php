<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 18:59
 * This is the ChannelDashboard_Controler. It is used to show various marketingchannels and how
 * they perform.
 */

require_once DOCUMENT_ROOT . 'Model/ChannelDashboard_Model.php';

/**
 * Class ChannelDashboard
 */
class ChannelDashboard_Controller extends Main_Controller
{
    /**
     * @var ChannelDashboardModel
     */
    public $model;

    /**
     * Default constructor.
     * Create's an instance of the model
     */
    public function __construct()
    {
        $this->model = new ChannelDashboard_Model();
    }

    /**
     * Index page control
     */
    public function index()
    {
        return $this->parse();
    }
}