<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:40
 * To change this template use File | Settings | File Templates.
 */

require_once DOCUMENT_ROOT . 'Controller/Router.php';
require_once DOCUMENT_ROOT . 'Model/Route.php';

$router = new Router();
$router->setBasePath(BASE_PATH);

$router->map('/', array('controller' => 'GoogleAuthentication_Controler', 'function' => 'CheckAuthentication'), array('methods' => 'GET'));