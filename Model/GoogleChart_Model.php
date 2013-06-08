<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 07-06-13
 * Time: 17:46
 * To change this template use File | Settings | File Templates.
 */

class GoogleChart_Model extends Main_Model
{
    /**
     * @var
     */
    public $chart_data;

    /**
     * @param $marketingchannels
     */
    public function setChartData($marketingchannels)
    {
        $json_object = array();

        // GoogleChart Model parses JSON
        foreach ($marketingchannels as $marketingchannel)
        {
            $json_object[$marketingchannel->marketingchannel] = $marketingchannel->revenue;
        }
        $this->chart_data = json_encode($json_object);
    }
}