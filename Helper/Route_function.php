<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:55
 * Fetches the URL and checks if the URL matches a defined route in the Route_config.php
 */
require CONTROLLER_ROOT . 'Main_Controller.php';

$route = $router->matchCurrentRequest();

if ($route)
{
    $target = $route->getTarget();
    $params = $route->getParameters();

    $controller_name = $target['controller'];
    $action = $target['action'];

    $main_controller = new Main_Controller();
    $controller = $main_controller->loadController($controller_name);

    Debug::p($router);
    Debug::p($route);
}
else
{
    $controller = new Main_Controller();
    $action = 'Index';

    Debug::p($router);
    Debug::p($route);
}

//$controller->$action();

?>