<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 04-06-13
 * Time: 14:53
 * To change this template use File | Settings | File Templates.
 */

class MarketingChannel extends GoogleAnalyticsMetricsParser
{
    public $marketingchannels;

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
        $dimensions = 'ga:source';
        $this->_params[] = 'source';

        // metrics
        $metrics = "ga:transactions";            // This metrics is only here because its required
        $this->_params[] = 'transactions';       // it's not used anywhere

        parent::__construct($metrics, $dimensions, $service, $profileId, $from, $to);
        $this->parse();
    }

    public function parse()
    {
        parent::parse();

        $this->marketingchannels = array();
        foreach ($this->_results as $array)
        {
            array_push($this->marketingchannels, $array['source']);
        }
    }
}