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
require_once MODEL_ROOT . 'WebshopSettings_Model.php';

require_once CONTROLLER_ROOT . 'GoogleChart_Controller.php';
/**
 * Class Dashboard_Controller
 */
class Dashboard_Controller extends Main_Controller
{
    /**
     * @var
     */
    public $googlechart_controller;

    /**
     * @var
     */
    public $webshop_id;

    /**
     * TODO: Verify that setup procedure has been completed (ALSO COSTS!!!)
     */
    public function index($params = null)
    {
        // Check if the Google Account is set so we can fetch the user website(s)
        $webshop_model = new Webshop_Model();

        if (isset($params['id'])) {
            if ($webshop_model->hasAccess($params['id'], $this->google_account->email)) {
                $this->dashboard($params['id']);
            }
        } else {
            $webshops = $webshop_model->getWebshopByEmail($this->google_account->email);
            $webshops_count = sizeof($webshops);

            // 0 Webshops set one up!
            if ($webshops_count == 0) {
                $this->setup();
            } // 1 webshop, open the dashboard!
            elseif ($webshops_count == 1) {
                $webshop = $webshops[0];
                $this->dashboard($webshop->id);
            } // More than 1, let the user select one
            else {
                $webshop_model->webshops = $webshops;
                $this->select($webshop_model);
            }
        }
    }

    /**
     * The actual dashboard.
     * @param $webshop_id
     */
    public function dashboard($params = null)
    {
        if (isset($params['id'])) {
            $webshop_id = $params['id'];
            $this->webshop_id = $webshop_id;

            $dashboard_model = new Dashboard_Model();
            $dashboard_model->getResultsPerMarketingChannel($webshop_id);
            $dashboard_model->getTotalRevenue($webshop_id);
            $dashboard_model->getWebshopCosts($webshop_id);

            $this->googlechart_controller = new GoogleChart_Controller();

            $this->parse($dashboard_model);
        } else {
            header('Location:' . WEBSITE_URL . 'dashboard');
        }
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

        if (isset($_POST) && !empty($_POST))
        {
            $webshop_setup_model->save($_POST, $this->google_account->id);
            $webshop_setup_model = null;
        }
        else
        {
            $webshop_setup_model->google_analytics_profiles = $this->google_client->google_analytics->listAllProfiles();
        }
        $this->parse($webshop_setup_model);
    }

    /**
     * Calls the 'save' view because that view loads the Magento + Analytics data for the first time.
     * @param $webshop_setup_model
     */
    public function save($webshop_setup_model)
    {
        $this->parse($webshop_setup_model);
    }

    /**
     * Calls the setup View. Can be used to add a Magento/Analytics configuration
     */
    public function edit($params = null)
    {
        if (isset($params['id'])) {
            $webshop_model = new Webshop_Model();
            $webshopSetttings_model = new WebshopSettings_Model($webshop_model->getById($params['id']));
            if (isset($_POST) && !empty($_POST) && $_POST['settings'] == "opslaan") {
                $webshopSetttings_model->updateWebshopSettings($_POST);
            }
            $this->parse($webshopSetttings_model);
        }
    }
}