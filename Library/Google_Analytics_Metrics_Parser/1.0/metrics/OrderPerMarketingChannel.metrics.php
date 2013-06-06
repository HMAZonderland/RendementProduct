<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 05-05-13
 * Time: 17:01
 * To change this template use File | Settings | File Templates.
 */

class OrderPerMarketingChannel extends GoogleAnalyticsMetricsParser
{
    /**
     * Constructor, passes on the service variable to the parser
     * @param Google_AnalyticsService $service
     * @param $profileId
     * @param Google_AnalyticsService $from
     * @param $to
     */
    public function __construct(Google_AnalyticsService $service, $profileId, $from, $to)
    {
        // dimensions
        $dimensions = 'ga:source,ga:transactionId';
        $this->_params[] = 'source';
        $this->_params[] = 'transactionId';

        // metrics
        $metrics = "ga:transactions";            // This metrics is only here because its required
        $this->_params[] = 'transactions';       // it's not used anywhere

        parent::__construct($metrics, $dimensions, $service, $profileId, $from, $to);
        $this->parse();
    }

    /**
     * Parses the metrics and dimmensions
     */
    public function parse()
    {
        parent::parse();
    }

    /**
     * Sorts the array by setting the orders per channel
     */
    public function getOrdersPerChannel()
    {
        Debug::p($this->_data);
        Debug::p($this->_results);

        $result = array();
        $source = null;
        $transactionId = null;

        foreach ($this->_results as $row) {
            foreach ($row as $key => $value) {
                if ($key == 'source') {
                    $source = $value;
                    if (!isset($result[$source])) {
                        $result[$source] = array();
                    }
                } elseif ($key == 'transactionId') {
                    $transactionId = $value;
                    array_push($result[$source], $transactionId);
                }
            }
        }
        return $result;
    }
}
