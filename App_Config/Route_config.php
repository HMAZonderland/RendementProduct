<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:40
 * To change this template use File | Settings | File Templates.
 */

require_once DOCUMENT_ROOT . 'Controller/Route_Controller.php';
require_once DOCUMENT_ROOT . 'Model/Route_Model.php';

$router = new Route_Controller();
$router->setBasePath('');

$router->map('/',           array('controller' => 'GoogleAuthentication_Controller',   'action' => 'checkAuthentication'),     array('methods' => 'GET'));
$router->map('/dashboard',  array('controller' => 'ChannelDashboard_Controller',       'action' => 'index'),                   array('methods' => 'GET'));
?>