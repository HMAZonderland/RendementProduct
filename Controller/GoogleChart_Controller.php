<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 07-06-13
 * Time: 17:45
 * To change this template use File | Settings | File Templates.
 */

require_once MODEL_ROOT . 'Dashboard_Model.php';
require_once MODEL_ROOT . 'GoogleChart_Model.php';

/**
 * Class GoogleChart_Controller
 */
class GoogleChart_Controller extends Main_Controller
{
    /**
     * @var
     */
    public $googlechart_model;

    /**
     * @param $webshop_id
     */
    public function pie($webshop_id)
    {
        $dashboard_model = new Dashboard_Model();
        $dashboard_model->getResultsPerMarketingChannel($webshop_id);

        $googlechart_model = new GoogleChart_Model();
        $googlechart_model->setChartData($webshop_id, $dashboard_model->results_per_marketingchannel);
        $this->parse($googlechart_model, true);
    }
}