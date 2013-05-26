<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:11
 * To change this template use File | Settings | File Templates.
 */

// Global used variables
define('WEBSITE_URL',       'http://product.esser-emmerik.hugozonderland.nl/');
define('DOCUMENT_ROOT',     '/home/ocrtxndf/domains/hugozonderland.nl/public_html/product.esser-emmerik');

// Model and controller root
define('MODEL_ROOT',        DOCUMENT_ROOT . '/Model');
define('CONTROLLER_ROOT',   DOCUMENT_ROOT . '/Controller');
define('LIBRARY_ROOT',      DOCUMENT_ROOT . '/Library');
define('HELPER_ROOT',       DOCUMENT_ROOT . '/Helper');

// Used for the templates
define('VIEW_ROOT',         DOCUMENT_ROOT . '/View');
define('SHARED_ROOT',       VIEW_ROOT . '/Shared');

// Includes made from the browser side
define('CSS_ROOT',          WEBSITE_URL . 'View/Static/css/');
define('IMAGE_ROOT',        WEBSITE_URL . 'View/Static/images/');
define('JAVASCRIPT_ROOT',   WEBSITE_URL . 'View/Static/javascript/');

// Includes made from the server/code side
define('HTML_ROOT',         DOCUMENT_ROOT . 'Static/html/');
?>