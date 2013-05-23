<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:55
 * To change this template use File | Settings | File Templates.
 */
require DOCUMENT_ROOT . '/App_Config/Router_config.php';
require DOCUMENT_ROOT . '/Controller/_Controller.php';

$route = $router->matchCurrentRequest();

if ($route)
{
    $target = $route->getTarget();
    $params = $route->getParameters();

    $controller = $target['controller'];
    $action = $target['action'];

    $controller = new Controller($controller, $action, $params);
}