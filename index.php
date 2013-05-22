<?php
error_reporting(E_ALL);

require dirname(__FILE__) . '/App_Config/Var_config.php';
require DOCUMENT_ROOT . '/App_Functions/Router_function.php';

$controller->render();
?>