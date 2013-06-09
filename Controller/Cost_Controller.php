<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 04-06-13
 * Time: 14:44
 * To change this template use File | Settings | File Templates.
 */
require_once MODEL_ROOT . 'Cost_Model.php';
require_once MODEL_ROOT . 'MarketingChannel_Model.php';
require_once MODEL_ROOT . 'GoogleAnalytics_Model.php';
require_once MODEL_ROOT . 'Webshop_Model.php';

/**
 * Class Cost_Controller
 */
class Cost_Controller extends Main_Controller
{
    /**
     * Starts the setup procedure
     *
     * @param $webshop_model
     */
    public function setup($params = null)
    {
        // Webshop
        $webshop_model = new Webshop_Model();

        // Check if the id is set, saves some time
        if (isset($params['id']))
        {
            if ($webshop_model->hasAccess($params['id'], $this->google_account->email))
            {
                // fetch the requested webshop
                $webshop = $webshop_model->getById($params['id']);

                // Parse!
                $this->screen($webshop);
            }
            else
            {
                // When this user has no acces, lets notify him
                $webshop_model->notification->error('Geen toegang..');
                $this->parse($webshop_model);
            }
        }
        else
        {
            $webshops = $webshop_model->getWebshopByEmail($this->google_account->email);
            if (sizeof($webshops) == 1)
            {
                $webshop = $webshops[0];
                $this->screen($webshop);
            }
            else
            {
                $this->select($webshops);
            }
        }
    }

    /**
     * @param $webshops
     */
    private function select($webshops)
    {
        $webshop_model = new Webshop_Model();
        $webshop_model->webshops = $webshops;
        $this->parse($webshop_model);
    }

    /**
     * @param $webshop
     */
    private function screen($webshop)
    {
        // Google Analytics Service
        $service = $this->google_client->google_analytics->google_analytics;

        // Google Analytics Model
        $google_analytics_model = new GoogleAnalytics_Model();

        // Marketingchannel model
        $marketingchannel_model = new MarketingChannel_Model();

        // See if there

        // Cost model
        $cost_model = new Cost_Model();
        $cost_model->webshop_id = $webshop->id;
        $cost_model->webshop_name = $webshop->name;

        $google_analytics_marketingchannels = $google_analytics_model->getMarketingChannels($service, $webshop->ga_profile);
        foreach ($google_analytics_marketingchannels as $google_analytics_marketingchannel)
        {
            // Dirty thing
            $marketingchannel_model->getIdByName($google_analytics_marketingchannel); // just to add missing ones.
            $marketingchannel = $marketingchannel_model->getByName($google_analytics_marketingchannel);
            array_push($cost_model->marketing_channels, $marketingchannel->name);
        }

        $this->parse($cost_model);
    }

    /**
     *
     */
    public function save()
    {
        // Cost Model
        $cost_model = new Cost_Model();

        // We do need POST vars
        if (isset($_POST) && !empty($_POST))
        {
            // Google Analytics Service
            $service = $this->google_client->google_analytics->google_analytics;

            // Google Analytics Model
            $google_analytics_model = new GoogleAnalytics_Model();

            // Webshop Model
            $webshop_model = new Webshop_Model();
            $webshop = $webshop_model->getById($_POST['webshop_id']);

            // MarketingchannelModel
            $marketingchannel_model = new MarketingChannel_Model();

            // Filll cost model
            $cost_model->marketing_channels = $marketingchannel_model->getAll();
            $cost_model->save($_POST);

            $cost_model->notification->success('Gegevens zijn opgeslagen.');
        }
        else
        {
            // add a notification
            $cost_model->notification->error('Kon niet opgeslagen worden omdat er geen data is.');
        }

        // parse the model
        $this->parse($cost_model);
    }
}