<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:40
 * This file is used to map URL's to controllers and actions => router configuration
 */

$router = new Route_Controller();
$router->setBasePath('');

$router->map('/',                           array('controller' => 'Dashboard_Controller',       'action' => 'index'),           array('methods' => 'GET'));
$router->map('/auth',                       array('controller' => 'Main_Controller',            'action' => 'auth'),            array('methods' => 'GET'));
$router->map('/logout',                     array('controller' => 'Main_Controller',            'action' => 'logout'),          array('methods' => 'GET'));
$router->map('/settings',                   array('controller' => 'Main_Controller',            'action' => 'settings'),        array('methods' => 'GET'));

$router->map('/dashboard',                  array('controller' => 'Dashboard_Controller',       'action' => 'index'),           array('methods' => 'GET'));
$router->map('/dashboard/:id',              array('controller' => 'Dashboard_Controller',       'action' => 'dashboard'),       array('methods' => 'GET',       'filters' => array('id' => '(\d+)')));
$router->map('/dashboard/setup',            array('controller' => 'Dashboard_Controller',       'action' => 'setup'),           array('methods' => 'GET,POST'));
$router->map('/dashboard/edit/:id',         array('controller' => 'Dashboard_Controller',       'action' => 'edit'),            array('methods' => 'GET,POST',  'filters' => array('id' => '(\d+)')));

$router->map('/dashboard/cost/setup/:id',   array('controller' => 'Cost_Controller',            'action' => 'setup'),           array('methods' => 'GET',       'filters' => array('id' => '(\d+)')));
$router->map('/dashboard/cost/setup/',      array('controller' => 'Cost_Controller',            'action' => 'save'),            array('methods' => 'POST'));
$router->map('/dashboard/cost/edit/:id',    array('controller' => 'Cost_Controller',            'action' => 'edit'),            array('methods' => 'GET,POST',  'filters' => array('id' => '(\d+)')));
$router->map('/dashboard/channel/:id/:marketingchannel_id',      array('controller' => 'ChannelDashboard_Controller','action' => 'dashboard'),  array('methods' => 'GET', 'filters' => array('id' => '(\d+)', 'marketingchannel_id' => '(\d+)')));

$router->map('/cron',                       array('controller' => 'Cronjob_Controller',         'action' => 'cronjob'),         array('methods' => 'GET'));
$router->map('/cron/forwebshop/:id',        array('controller' => 'Cronjob_Controller',         'action' => 'forwebshop'),      array('methods' => 'GET',       'filters' => array('id' => '(\d+)')));
?>