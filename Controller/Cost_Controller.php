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
    public function setup()
    {
        // Webshop
        $webshop_model = new Webshop_Model();
        $webshop_model->getWebshopByEmail($this->google_account->email);
        $webshops = sizeof($webshop_model->webshops);

        // When there is more than webshop we need to check which one..
        if ($webshops > 1)
        {
            $this->select($webshop_model);
        }
        // If there is just one, setup!
        elseif ($webshops == 1)
        {
            // Improve readability
            $webshop = $webshop_model->webshops[0];

            // Google Analytics Service
            $service = $this->google_client->google_analytics->google_analytics;

            // Google Analytics Model
            $google_analytics_model = new GoogleAnalytics_Model();

            // Marketingchannel model
            $marketingchannel_model = new MarketingChannel_Model();

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
        // If there are 0, the user isn't suppose to be here, so redirect him!
        elseif ($webshops == 0)
        {
            header('Location:' . WEBSITE_URL . 'dashboard/setup');
        }
    }

    /**
     * Checks the webshopcost connected to this webshop
     * when its undefined we're going to define costs.
     *
     * @param $webshop_model
     */
    public function select($webshop_model)
    {
        $cost_model = new Cost_Model();
        foreach($webshop_model as $webshop)
        {
            $cost = $cost_model->getByWebshopId($webshop->id);
            if ($cost == null)
            {
                // This webshop doesn't have cost defined.
                $this->setup($webshop);
                exit();
            }
        }
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