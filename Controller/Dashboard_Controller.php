<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 28-05-13
 * Time: 10:37
 * To change this template use File | Settings | File Templates.
 */

require_once MODEL_ROOT . 'Webshop_Model.php';
require_once MODEL_ROOT . 'WebshopSetup_Model.php';
require_once MODEL_ROOT . 'Dashboard_Model.php';

/**
 * Class Dashboard_Controller
 */
class Dashboard_Controller extends Main_Controller
{
    /**
     *
     */
    public function index()
    {
        // Check if the Google Account is set so we can fetch the user website(s)
        $webshop_model = new Webshop_Model();
        $webshop_model->getWebshopByEmail($this->google_account->email);
        $webshops = sizeof($webshop_model->webshops);

        // 0 Webshops set one up!
        if ($webshops == 0)
        {
            $this->setup();
        }
        // 1 webshop, open the dashboard!
        elseif ($webshops == 1)
        {
            $this->dashboard($webshop_model->webshops[1]->id);
        }
        // More than 1, let the user select one
        else
        {
            $this->select($webshop_model);
        }
    }

    /**
     * The actual dashboard.
     * @param $webshop_id
     */
    public function dashboard($webshop_id)
    {
        $dashboard_model = new Dashboard_Model();
        $this->parse($dashboard_model);
    }

    /**
     * Webshop selector view
     * @param $webshops
     */
    private function select($webshop_model)
    {
        $this->parse($webshop_model);
    }


    /**
     * Calls the setup View. Can be used to add a Magento/Analytics configuration
     */
    public function setup()
    {
        $webshop_setup_model = new WebshopSetup_Model();
        $webshop_setup_model->google_analytics_profiles = $this->google_client->google_analytics->listAllProfiles();
        $this->parse($webshop_setup_model);
    }

    /**
     * Fetches the POST request and processes it variables
     */
    public function save()
    {
        $webshop_setup_model = new WebshopSetup_Model();
        if (isset($_POST) && !empty($_POST))
        {
            $webshop_setup_model->save($_POST, $this->google_account->id);
        }
        $this->parse($webshop_setup_model);
    }
}