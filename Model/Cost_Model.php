<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 04-06-13
 * Time: 14:45
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class Cost_Model
 */
class Cost_Model extends Main_Model
{
    /**
     * @var array
     */
    public $marketing_channels = array();

    /**
     * webshop.id
     * @var int
     */
    public $webshop_id;

    /**
     * webshop.name
     * @var string
     */
    public $webshop_name;

    /**
     * @param $post_data
     * @param $google_account_id
     */
    public function save($post_data)
    {
        /*
         * TODO: Better form validation
         * 1. cost has to be more than 0
         * 2. the marketingchannel posted really has to be connected to this webshop
         * 3. for each marketingchannel the cost has to be more than 0
         */
        $webshop_cost = R::dispense('webshopcost');
        $webshop_cost->webshop_id   =   $post_data['webshop_id'];   // webshop specific
        $webshop_cost->cost         =   $post_data['cost'];
        $webshop_cost->date         =   date("Y-m-d H:i:s");        // can vary per month
        R::store($webshop_cost);

        Debug::s($this->marketing_channels);


        // Process the marketingchannels
        if (isset($this->marketing_channels) && sizeof($this->marketing_channels) > 0)
        {
            foreach ($this->marketing_channels as $marketing_channel)
            {
                if (isset($marketing_channel->name))
                {
                    // Noone will have additional cost to direct trafic.
                    if ($marketing_channel->name != '(direct)')
                    {
                        // Define the field names on the view
                        $fieldname = str_replace('.', '_', $marketing_channel->name);
                        $fieldname = $fieldname . '_cost';

                        // There has to be data!
                        if (array_key_exists($fieldname, $post_data))
                        {
                            $marketing_channel_cost = R::dispense('marketingchannelcost');
                            $marketing_channel_cost->marketingchannel_id    =   $marketing_channel->id;
                            $marketing_channel_cost->webshop_id             =   $post_data['webshop_id'];   // specific per webshop
                            $marketing_channel_cost->cost                   =   $post_data[$fieldname];
                            $marketing_channel_cost->date                   =   date("Y-m-d H:i:s");        // may vary per month
                            R::store($marketing_channel_cost);
                        }
                    }
                }
            }
        }
        // Berichtgeving
        $this->notification->success('Vaste lasten & kosten per marketingkanaal zijn opgeslagen!');
    }

    /**
     * Finds webshop cost by webshop id.
     *
     * @param $webshop_id
     *
     * @return RedBean_OODBBean
     */
    public function getByWebshopId($webshop_id)
    {
        return R::Load('webshopcot', $webshop_id);
    }
}