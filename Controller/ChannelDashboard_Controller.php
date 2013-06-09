<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-06-13
 * Time: 09:22
 * To change this template use File | Settings | File Templates.
 */
require_once MODEL_ROOT . 'ChannelDashboard_Model.php';
require_once MODEL_ROOT . 'Dashboard_Model.php';

/**
 * Class ChannelDashboard_Controller
 */
class ChannelDashboard_Controller extends Main_Controller
{
    /**
     * @param $params
     */
    public function dashboard($params)
    {
        $webshop_id = $params['id'];
        $marketingchannel_id = $params['marketingchannel_id'];

        $dashboard_model = new Dashboard_Model();
        $dashboard_model->getWebshopCosts($webshop_id);

        $channeldashboard_model = new ChannelDashboard_Model();
        $channeldashboard_model->webshop_costs = $dashboard_model->webshop_costs;
        $channeldashboard_model->productsByMarketingChannelAndWebshopId($webshop_id, $marketingchannel_id);
        $channeldashboard_model->soldproducts($webshop_id, $marketingchannel_id);
        $channeldashboard_model->ratio($webshop_id, $marketingchannel_id);
        $this->parse($channeldashboard_model);
    }
}
