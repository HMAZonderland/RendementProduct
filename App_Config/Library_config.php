<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 26-05-13
 * Time: 16:01
 * This file is used to map library files.
 */

define ('LIBRARY', serialize(array(
    // Google Client library
    'Google_API_Client'                     => LIBRARY_ROOT . 'Google_API_Client/0.6.2/Google_Client.php',
    'Google_Analytics_Service'              => LIBRARY_ROOT . 'Google_API_Client/0.6.2/contrib/Google_AnalyticsService.php',
    'Google_Oauth2Service'                  => LIBRARY_ROOT . 'Google_API_Client/0.6.2/contrib/Google_Oauth2Service.php',

    // Lose libraries
    'MagentoClient'                         => LIBRARY_ROOT . 'MagentoClient/1.0/MagentoClient.php',
    'RedBeanPHP'                            => LIBRARY_ROOT . 'RedBeanPHP/3.4/rb.php',

    // Metrics parser + metricses
    'Google_Analytics_Metrics_Parser'       => LIBRARY_ROOT . 'Google_Analytics_Metrics_Parser/1.0/GoogleAnalyticsMetricsParser.php',
    'OrderPerMarketingChannel_Metrics'      => LIBRARY_ROOT . 'Google_Analytics_Metrics_Parser/1.0/metrics/OrderPerMarketingChannel.metrics.php',
    'MarketingChannel_Metrics'              => LIBRARY_ROOT . 'Google_Analytics_Metrics_Parser/1.0/metrics/MarketingChannel.metrics.php'
)));
?>