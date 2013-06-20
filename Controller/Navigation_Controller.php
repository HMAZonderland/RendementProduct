<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 20-06-13
 * Time: 17:59
 * To change this template use File | Settings | File Templates.
 */
class Navigation_Controller
{
    public function __construct()
    {

    }

    public function get()
    {
        $path = parse_url($_SERVER['REQUEST_URI']);
        $path = substr($path['path'], 1, strlen($path['path']));
        ?>
        <li id="menu-item-48">
            <a href="<?=WEBSITE_URL . $path?>" onclick="clickDay();">Dag niveau</a>
        </li>
        <li id="menu-item-288">
            <a href="<?=WEBSITE_URL . $path?>" onclick="clickWeek();">Week niveau</a>
        </li>
        <li id="menu-item-288">
            <a href="<?=WEBSITE_URL . $path?>" onclick="clickMonth();">Maand niveau</a>
        </li>
        <li id="menu-item-48">
            <a href="<?=WEBSITE_URL?>settings">Instellingen</a>
        </li>
        <li id="menu-item-288">
            <a href="<?=WEBSITE_URL?>logout">Logout</a>
        </li>
        <?
    }
}