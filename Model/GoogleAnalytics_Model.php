<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-06-13
 * Time: 10:45
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class GoogleAnalytics_Model
 */
class GoogleAnalytics_Model extends Main_Model
{
    /**
     * Returns the orders of the past 24 hours
     *
     * @param $service
     * @param $google_analytics_profile
     *
     * @return array
     */
    public function getTransactionsPerMarketingChannel24Hours($service, $google_analytics_profile)
    {
        $from_time = time() - 24 * 60 * 60;
        return $this->getTransactionsPerMarketingChannel($service, $google_analytics_profile, $from_time);
    }

    /**
     * Returns all the orders from the past month
     *
     * @param $service
     * @param $google_analytics_profile
     *
     * @return array
     */
    public function getTransactionsPerMarketingChannelMonth($service, $google_analytics_profile)
    {
        $from_time = time() - date('t') * 24 * 60 * 60;
        return $this->getTransactionsPerMarketingChannel($service, $google_analytics_profile, $from_time);
    }

    /**
     * @param $service
     * @param $google_analytics_profile
     * @param $from_time
     *
     * @return array
     */
    private function getTransactionsPerMarketingChannel($service, $google_analytics_profile, $from_time)
    {
        // Load the Google Analytics Metrics parser + OrderPerMarketingChannel metrics
        Library::load('Google_Analytics_Metrics_Parser');
        Library::load('OrderPerMarketingChannel_Metrics');

        // 24 hour time filter
        $from = date('Y-m-d', $from_time);
        $to = date('Y-m-d');

        // Initiate the metrics, fetch and return the results
        $order_per_marketing_channel_metrics = new OrderPerMarketingChannel($service, $google_analytics_profile, $from, $to);
        $orders = $order_per_marketing_channel_metrics->getOrdersPerChannel();
        return $orders;
    }


    /**
     * @param $service
     * @param $google_analytics_profile
     *
     * @return array
     */
    public function getMarketingChannels($service, $google_analytics_profile)
    {
        // Load the Google Analytics Metrics parser + OrderPerMarketingChannel metrics
        Library::load('Google_Analytics_Metrics_Parser');
        Library::load('MarketingChannel_Metrics');

        // 1 month hour time filter
        $from = date('Y-m-d', time() - 30 * 24 * 60 * 60);
        $to = date('Y-m-d');

        // Initiate the metrics, fetch and return the results
        $marketingchannel = new MarketingChannel($service, $google_analytics_profile, $from, $to);
        $marketingchannel = $marketingchannel->marketingchannels;
        return $marketingchannel;
    }
}