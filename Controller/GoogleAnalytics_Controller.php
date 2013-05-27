<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 27-05-13
 * Time: 13:11
 * To change this template use File | Settings | File Templates.
 */

class GoogleAnalytics_Controller
{
    /**
     * @var Google_AnalyticsService
     */
    private $google_analytics;

    /**
     * @param $google_client
     */
    public function __construct($google_client)
    {
        $this->google_analytics = new Google_AnalyticsService($google_client);
    }
}