<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 26-05-13
 * Time: 16:28
 * Boostrap file. Sets enviroment variables
 */
session_start();

// We always want logs, we LOVE logs!
ini_set('log_errors', 1);
ini_set('error_log', LOG_ROOT . 'error.log');
ob_start();

// Global used variables
define('WEBSITE_URL',       'http://product.esser-emmerik.hugozonderland.nl/');
define('DOCUMENT_ROOT',     '/home/ocrtxndf/domains/hugozonderland.nl/public_html/product.esser-emmerik/');
define('CONFIG_ROOT',        DOCUMENT_ROOT . 'App_Config/');
define('TMP_ROOT',           DOCUMENT_ROOT . 'Temporary/');
define('LOG_ROOT',           TMP_ROOT . 'Logs/');

// Model and controller root
define('MODEL_ROOT',        DOCUMENT_ROOT . 'Model/');
define('CONTROLLER_ROOT',   DOCUMENT_ROOT . 'Controller/');
define('LIBRARY_ROOT',      DOCUMENT_ROOT . 'Library/');
define('HELPER_ROOT',       DOCUMENT_ROOT . 'Helper/');

// Used for the templates
define('VIEW_ROOT',         DOCUMENT_ROOT . 'View/');
define('SHARED_ROOT',       VIEW_ROOT . 'Shared/');

// Includes made from the browser side
define('CSS_ROOT',          WEBSITE_URL . 'View/Static/css/');
define('IMAGE_ROOT',        WEBSITE_URL . 'View/Static/images/');
define('JAVASCRIPT_ROOT',   WEBSITE_URL . 'View/Static/javascript/');

// Includes made from the server/code side
define('HTML_ROOT',         DOCUMENT_ROOT . 'Static/html/');

// Load the debug helper first
include_once(HELPER_ROOT . 'Debug_function.php');

// Load the Library config + helper
include_once(CONFIG_ROOT . 'Library_config.php');
include_once(HELPER_ROOT . 'Library_function.php');

// Load the Database config + load the library + inits + load helper the connection
include_once(CONFIG_ROOT . 'Db_config.php');
Library::load('RedBeanPHP');
R::setup('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', '' . DB_USERNAME . '', '' . DB_PASS . '');

// Production/Debug
define('STATUS', 'development');

// Setting various settings according to status
switch (STATUS)
{
    case 'production': {
        ini_set('display_errors', 0);
        define('OUTPUT_DEBUG', false);
        R::debug(false);
        R::freeze(true);
    }

    case 'development': {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        define('OUTPUT_DEBUG', true);
        R::debug(true);
    }
}

// Load the Google API Client config, library and helper
include_once(CONFIG_ROOT . 'Google_API_Client_config.php');
Library::load('Google_API_Client');
Library::load('Google_Analytics_Service');
Library::load('Google_Oauth2Service');

// Load the route config + helper
include_once(CONFIG_ROOT . 'Route_config.php');
include_once(HELPER_ROOT . 'Route_function.php');
?>

