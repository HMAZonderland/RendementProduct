<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-05-13
 * Time: 17:31
 * Creates an instance of the MagentoClient (see library)
 */
$mClient = new MagentoClient($settings->magento_api_username, $settings->magento_api_key, $settings->magento_api_url);
?>