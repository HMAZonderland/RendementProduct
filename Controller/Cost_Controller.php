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
     * Save function, verifies the current user + saves the form data submitted
     */
    public function save()
    {
        // Cost Model
        $cost_model = new Cost_Model();

        // We do need POST vars
        if (isset($_POST) && !empty($_POST))
        {
            // Webshop Model to verify the current user + action
            $webshop_model = new Webshop_Model();
            if ($webshop_model->hasAccess($_POST['webshop_id'], $this->google_account->email))
            {
                // MarketingchannelModel
                $marketingchannel_model = new MarketingChannel_Model();

                // Filll cost model
                $cost_model->marketing_channels = $marketingchannel_model->getAll();
                $cost_model->save($_POST);
            }
            else
            {
                // No access, output an error.
                $cost_model->notification->error('Geen toegang tot deze functie!');
            }
        }
        else
        {
            // add a notification
            $cost_model->notification->error('Kon niet opgeslagen worden omdat er geen data is.');
        }

        // parse the model
        $this->parse($cost_model);
    }

    /**
     * @param null $params
     */
    public function edit($params = null)
    {
        // Cost model
        $cost_model = new Cost_Model();

        if ($params != null)
        {
            // Webshop Model
            $webshop_model = new Webshop_Model();

            // when we have to get the page..
            if (empty($_POST))
            {
                // Verify the get request
                if ($webshop_model->hasAccess($params['id'], $this->google_account->email))
                {
                    $webshop = $webshop_model->getById($params['id']);
                    // Google Analytics Service
                    $service = $this->google_client->google_analytics->google_analytics;

                    // Google Analytics Model
                    $google_analytics_model = new GoogleAnalytics_Model();

                    // Marketingchannel model
                    $marketingchannel_model = new MarketingChannel_Model();

                    $cost_model->webshop_id = $webshop->id;
                    $cost_model->webshop_name = $webshop->name;
                    $cost_model->webshop_cost = $cost_model->getWebshopCost($webshop->id)->cost;

                    $google_analytics_marketingchannels = $google_analytics_model->getMarketingChannels($service, $webshop->ga_profile);
                    foreach ($google_analytics_marketingchannels as $google_analytics_marketingchannel)
                    {
                        // Dirty thing
                        $marketingchannel_model->getIdByName($google_analytics_marketingchannel); // just to add missing ones.
                        $marketingchannel = $marketingchannel_model->getMarketingChannelAndCostByName($google_analytics_marketingchannel);
                        if ($marketingchannel != null)
                        {
                            array_push($cost_model->marketing_channels, $marketingchannel);
                        }
                    }
                }
                else
                {
                    $cost_model->notification->error('Geen toegang tot de instellingen van deze webshop.');
                }
            }
            // when there is post data
            else
            {
                // Verify the post data
                if ($webshop_model->hasAccess($_POST['webshop_id'], $this->google_account->email))
                {
                    // MarketingchannelModel
                    $marketingchannel_model = new MarketingChannel_Model();

                    // Filll cost model
                    $cost_model->marketing_channels = $marketingchannel_model->getAll();
                    $cost_model->save($_POST);
                }
                else
                {
                    $cost_model->notification->error('De rechten om de instellingen van deze webshop te updaten.');
                }
            }
        }
        else
        {
            $cost_model->notification->error('Geen id gezet.');
        }
        $this->parse($cost_model);
    }
}