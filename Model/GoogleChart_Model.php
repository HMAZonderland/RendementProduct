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
    public function setChartData($webshop_id, $marketingchannels)
    {
        $json_object = array();
        $json_object['webshop_id'] = $webshop_id;
        $json_object['marketing_channels'] = array();

        // GoogleChart Model parses JSON
        foreach ($marketingchannels as $marketingchannel)
        {
            $obj = array();
            $obj['id'] = $marketingchannel->id;
            $obj['name'] = $marketingchannel->marketingchannel;
            $obj['revenue'] = $marketingchannel->revenue;
            array_push($json_object['marketing_channels'], $obj);
        }
        $this->chart_data = json_encode($json_object);
    }
}