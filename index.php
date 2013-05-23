<?php
error_reporting(E_ALL);

require dirname(__FILE__) . '/App_Config/Var_config.php';
require DOCUMENT_ROOT . '/Helper/Router_function.php';

$main_controller->render();
?>