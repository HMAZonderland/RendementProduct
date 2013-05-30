<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:40
 * This file is used to map URL's to controllers and actions.
 */

require_once DOCUMENT_ROOT . 'Controller/Route_Controller.php';
require_once DOCUMENT_ROOT . 'Model/Route_Model.php';

$router = new Route_Controller();
$router->setBasePath('');

$router->map('/',                   array('controller' => 'Dashboard_Controller',   'action' => 'index'),   array('methods' => 'GET'));
$router->map('/auth',               array('controller' => 'Main_Controller',        'action' => 'auth'),    array('methods' => 'GET'));
$router->map('/logout',             array('controller' => 'Main_Controller',        'action' => 'logout'),  array('methods' => 'GET'));

$router->map('/dashboard',              array('controller' => 'Dashboard_Controller',   'action' => 'index'),   array('methods' => 'GET'));
$router->map('/dashboard/setup',        array('controller' => 'Dashboard_Controller',   'action' => 'setup'),   array('methods' => 'GET'));
$router->map('/dashboard/setup',        array('controller' => 'Dashboard_Controller',   'action' => 'save'),    array('methods' => 'POST'));
?>