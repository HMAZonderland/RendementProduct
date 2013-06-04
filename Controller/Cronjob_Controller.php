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

    /**
     * Starts up the GoogleClient
     */
    public function __construct()
    {
        $this->google_client = new GoogleClient_Controller();
    }

    /**
     * Fetches the orders per marketing channel from Google Analytics.
     * Requests these at the Magento Store
     */
    public function process()
    {
        // Fetch all the webshops from the database
        $webshop_model = new Webshop_Model();
        $webshops = $webshop_model->getAll();

        // Google Analytics Service
        $service = $this->google_client->google_analytics->google_analytics;

        // Google Analytics Model
        $google_analytics_model = new GoogleAnalytics_Model();

        // Google Account Model
        $google_account_model = new GoogleAccount_Model();

        // Marketingchannel Model
        $marketingchannel_model = new MarketingChannel_Model();

        // Produt Model
        $product_model = new Product_Model();

        // Order model
        $order_model = new Order_Model();

        // Load the MagentoClient library
        Library::load('MagentoClient');

        foreach ($webshops as $webshop)
        {
            // Magento Client, needs to be reinitated for each webshop
            $magento_client = new MagentoClient($webshop->magento_user, $webshop->magento_key, $webshop->magento_host);

            // Refresh token setting
            $refresh_token = $google_account_model->getRefreshTokenByWebshopId($webshop->id);
            if (is_string($refresh_token))
            {
                $this->google_client->google_client->refreshToken($refresh_token);

                // Get the transactions per marketingchannel from Google Analytics.
                $transactions = $google_analytics_model->getTransactionsPerMarketingChannel($service, $webshop->ga_profile);

                foreach ($transactions as $marketingchannel_name => $transactions)
                {
                    // Find this marketingchannel
                    // add when it doesn't exsist, get it's id when it does
                    $marketingchannel_id = $marketingchannel_model->getIdByName($marketingchannel_name);

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
                            $product_id = $product_model->getIdBySku($mProduct['sku'], $mProduct['name'], $webshop->id);
                            $product_model->verifyPrices($mProduct, $product_id);

                            // Setting values for the product order array.
                            $product['product_id'] = $product_id;
                            $product['quantity'] = $mProduct['qty_ordered'];
                            array_push($products_order, $product);
                        }
                        // Store and connect all the pieces
                        $order_model->add($marketingchannel_id, $webshop->id, $shipping_amount, $order['created_at'], $products_order);
                    }
                }
                // Echo output for the cronjob mailer.
                echo 'Processed ' . $webshop->name . '<br />';
            }
            else
            {
                echo 'Could not process ' . $webshop->name . '<br />';
            }
        }
    }
}