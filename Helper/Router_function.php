<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:55
 * To change this template use File | Settings | File Templates.
 */
require DOCUMENT_ROOT . '/App_Config/Router_config.php';
require DOCUMENT_ROOT . '/Controller/Main_Controller.php';

$route = $router->matchCurrentRequest();

if ($route)
{
    $target = $route->getTarget();
    $params = $route->getParameters();

    $controller = $target['controller'];
    $action = $target['action'];

    $main_controller = new Main_Controller($controller, $action, $params);
}