<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 26-05-13
 * Time: 15:40
 * This is the default template view for the webapplication.
 * It includes the header, navigation, the needed view and the footer
 */
include SHARED_ROOT . '_header.html.php';
include SHARED_ROOT . '_navigation.html.php';

$this->renderView();

include SHARED_ROOT . '_footer.html.php';
?>