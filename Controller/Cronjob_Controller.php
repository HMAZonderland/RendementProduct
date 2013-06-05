<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-06-13
 * Time: 10:14
 * To change this template use File | Settings | File Templates.
 */
require_once CONTROLLER_ROOT . 'GoogleClient_Controller.php';

require_once MODEL_ROOT . 'GoogleAnalytics_Model.php';
require_once MODEL_ROOT . 'GoogleAccount_Model.php';
require_once MODEL_ROOT . 'MagentoOrder_Model.php';
require_once MODEL_ROOT . 'MarketingChannel_Model.php';
require_once MODEL_ROOT . 'Webshop_Model.php';
require_once MODEL_ROOT . 'Product_Model.php';
require_once MODEL_ROOT . 'Order_Model.php';

/**
 * Class Cronjob_Controller
 */
class Cronjob_Controller
{
    /**
     * @var GoogleClient_Controller
     */
    public $google_client;

    public $service;

    public $google_analytics_model;

    public $google_account_model;

    public $marketingchannel_model;

    public $product_model;

    public $order_model;

    /**
     * Fires up al the models etc.
     */
    public function __construct()
    {
        // Google Client
        $this->google_client = new GoogleClient_Controller();

        // Fetch all the webshops from the database
        $this->webshop_model = new Webshop_Model();

        // Google Analytics Service
        $this->service = $this->google_client->google_analytics->google_analytics;

        // Google Analytics Model
        $this->google_analytics_model = new GoogleAnalytics_Model();

        // Google Account Model
        $this->google_account_model = new GoogleAccount_Model();

        // Marketingchannel Model
        $this->marketingchannel_model = new MarketingChannel_Model();

        // Produt Model
        $this->product_model = new Product_Model();

        // Order model
        $this->order_model = new Order_Model();
    }

    /**
     * Fetches the orders per marketing channel from Google Analytics.
     * Requests these at the Magento Store
     */
    public function cronjob()
    {
        // This is the cronjob, fetch em all!
        $webshops = $this->webshop_model->getAll();

        // Process each webshop!
        foreach ($webshops as $webshop)
        {
            // Get the transactions per marketingchannel from past month from Google Analytics.
            $transactions = $this->google_analytics_model->getTransactionsPerMarketingChannel24Hours($this->service, $webshop->ga_profile);

            if (sizeof($transactions) > 0)
            {
                if ($this->process($webshop, $transactions))
                {
                    echo 'Processed ' . $webshop->name . '<br />';
                }
                else
                {
                    echo 'Could not process ' . $webshop->name . '<br />';
                }
            }
            else
            {
                echo $webshop->name . ' had no orders the past 24 hours.';
            }
        }
    }

    /**
     * Processes the the cronjob for a single webshop..
     */
    public function forwebshop()
    {
        // Get the ID
        $id = $_GET['id'];

        // Get the webshop assiated
        $webshop = $this->webshop_model->getById($id);

        // We have to be sure..
        if ($webshop != null)
        {
            // Get the transactions per marketingchannel from past month from Google Analytics.
            $transactions = $this->google_analytics_model->getTransactionsPerMarketingChannelMonth($this->service, $webshop->ga_profile);

            if ($this->process($webshop, $transactions))
            {
                echo 'true';
            }
            else
            {
                echo 'false';
            }
        }
    }

    private function process($webshop, $transactions)
    {
        // Load the MagentoClient library
        Library::load('MagentoClient');

        // Magento Client, needs to be reinitated for each webshop
        $magento_client = new MagentoClient($webshop->magento_user, $webshop->magento_key, $webshop->magento_host);

        // Refresh token setting
        $refresh_token = $this->google_account_model->getRefreshTokenByWebshopId($webshop->id);
        if (is_string($refresh_token))
        {
            $this->google_client->google_client->refreshToken($refresh_token);

            foreach ($transactions as $marketingchannel_name => $transactions)
            {
                // Find this marketingchannel
                // add when it doesn't exsist, get it's id when it does
                $marketingchannel_id = $this->marketingchannel_model->getIdByName($marketingchannel_name);

                // Process the orders within this marketingchannel
                foreach ($transactions as $order_id)
                {
                    // Get the order details
                    // define the shipping cost on this order
                    $order = $magento_client->getSalesOrderDetails($order_id);
                    $shipping_amount = $order['shipping_amount'];

                    // Used to add products to the order table
                    $products_order = array();

                    // Process the items on this order
                    foreach ($order['items'] as $mProduct)
                    {
                        // Get the product id
                        // or add it when we cannot find it.
                        $product_id = $this->product_model->getIdBySku($mProduct['sku'], $mProduct['name'], $webshop->id);
                        $this->product_model->verifyPrices($mProduct, $product_id);

                        // Setting values for the product order array.
                        $product['product_id'] = $product_id;
                        $product['quantity'] = $mProduct['qty_ordered'];
                        array_push($products_order, $product);
                    }
                    // Store and connect all the pieces
                    $this->order_model->add($marketingchannel_id, $webshop->id, $shipping_amount, $order['created_at'], $products_order);
                }
            }
        }
        else
        {
            return false;
        }
        return true;
    }
}