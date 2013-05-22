<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 19:07
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class ChannelDashboardModel
 *
 * Dummy class, for now.
 */
class ChannelDashboard_Model extends RedBean_SimpleModel
{
    /**
     * @var string
     */
    public $abc;

    /**
     *
     */
    public function __construct()
    {
        $this->abc = "Dit is de ABC waarde van de ChannelDashboard_Model";
    }
}