<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 19:07
 * Default model
 */


/**
 * Class ChannelDashboardModel
 *
 * Dummy class, for now.
 */
class ChannelDashboard_Model
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

    /**
     * @param string $abc
     */
    public function setAbc($abc)
    {
        $this->abc = $abc;
    }

    /**
     * @return string
     */
    public function getAbc()
    {
        return $this->abc;
    }
}