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

    // Create an instance of the Main_Controller
    $main_controller = new Main_Controller();

    // When the request controller is NOT the Main Controller we have to load this controller
    if ($controller_name != 'Main_Controller' && $controller_name != 'Cronjob_Controller')
    {
        $controller = $main_controller->loadController($controller_name);
        $controller->init();
    }
    elseif ($controller_name == 'Cronjob_Controller')
    {
        $controller = $main_controller->loadController($controller_name);
    }
    else
    {
        // When it is, we have to talk to the Main Controller directly
        $controller = $main_controller;
        $controller->init();
    }
}
else
{
    $controller = new Main_Controller();
    //$controller->checkAuthentication();
    $action = 'checkAuthentication';
    $params = array();
}

$controller->$action($params);
?>