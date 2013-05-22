<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:40
 * To change this template use File | Settings | File Templates.
 */

require_once DOCUMENT_ROOT . '/Controller/_Router.php';
require_once DOCUMENT_ROOT . '/Model/_Route.php';

$router = new Router();
$router->setBasePath('');

$router->map('/',           array('controller' => 'GoogleAuthentication',   'action' => 'CheckAuthentication'),     array('methods' => 'GET'));
$router->map('/dashboard',  array('controller' => 'ChannelDashboard',       'action' => 'index'),                   array('methods' => 'GET'));

?>