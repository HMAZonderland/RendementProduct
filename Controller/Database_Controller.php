<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 23:34
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class DatabaseController
 *
* Handles all database communication using RedBeansPHP library
*/
class Database_Controller
{
    /**
     * Sets up the connection to the database
     */
    public function __construct()
    {
        Library::load('RedBeanPHP');
        R::setup('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', '' . DB_USERNAME . '', '' . DB_PASS . '');
    }
}