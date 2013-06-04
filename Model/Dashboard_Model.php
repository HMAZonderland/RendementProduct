<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 30-05-13
 * Time: 15:51
 * To change this template use File | Settings | File Templates.
 */

class Dashboard_Model extends Main_Model
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        // Select from revenue etc etc.
        $this->notification->warning('Er is nog geen data om berekeningen op uit te voeren.');
    }
}