<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-06-13
 * Time: 10:45
 * To change this template use File | Settings | File Templates.
 */

class GoogleAnalytics_Model extends Main_Model
{
    public function getTransactionsPerMarketingChannel($service, $google_analytics_profile)
    {
        // Load the Google Analytics Metrics parser + OrderPerMarketingChannel metrics
        Library::load('Google_Analytics_Metrics_Parser');
        Library::load('OrderPerMarketingChannel_Metrics');

        // 24 hour time filter
        $from = date('Y-m-d', time() - 24 * 60 * 60);
        $to = date('Y-m-d');

        // Initiate the metrics, fetch and return the results
        $order_per_marketing_channel_metrics = new OrderPerMarketingChannel($service, $google_analytics_profile, $from, $to);
        $orders = $order_per_marketing_channel_metrics->getOrdersPerChannel();
        return $orders;
    }
}