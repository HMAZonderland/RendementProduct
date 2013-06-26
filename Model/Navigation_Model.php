<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 20-06-13
 * Time: 17:59
 * To change this template use File | Settings | File Templates.
 */
class Navigation_Model
{
    public function get()
    {
        $path = parse_url($_SERVER['REQUEST_URI']);
        $path = substr($path['path'], 1, strlen($path['path']));

        if (strpos($path, 'setup') === false)
        {
            ?>
            <li id="menu-item-48" class="<?= preg_match('/^dashboard$/', $path) || preg_match('#dashboard/(\d+)#', $path) || preg_match('#dashboard/channel/(\d+)/(\d)#', $path)? 'active' : '';?>">
                <a href="<?=WEBSITE_URL?>dashboard">Dashboard</a>
            </li>
            <?php
            if (preg_match('#dashboard/(\d+)#', $path) || preg_match('#dashboard/channel/(\d+)/(\d)#', $path))
            {
                ?>
                <li id="menu-item-48" class="<?= $_COOKIE['scope'] == 1 ? 'active': '';?>">
                    <a href="<?=WEBSITE_URL . $path?>" onclick="clickDay();">Dag niveau</a>
                </li>
                <li id="menu-item-288" class="<?= $_COOKIE['scope'] == 7 ? 'active': '';?>">
                    <a href="<?=WEBSITE_URL . $path?>" onclick="clickWeek();">Week niveau</a>
                </li>
                <li id="menu-item-288" class="<?= $_COOKIE['scope'] == 28 || $_COOKIE['scope'] == 29 || $_COOKIE['scope'] == 30 || $_COOKIE['scope'] == 31 ? 'active': '';?>">
                    <a href="<?=WEBSITE_URL . $path?>" onclick="clickMonth();">Maand niveau</a>
                </li>
                <?php
            }
            ?>
            <li id="menu-item-48" class="<?= preg_match('#dashboard/edit/(\d+)#', $path) || preg_match('#settings#', $path) || preg_match('#dashboard/cost/edit/(\d+)#', $path)? 'active' : '';?>">
                <a href="<?=WEBSITE_URL?>settings">Instellingen</a>
            </li>
        <?php
        }
        ?>
        <li id="menu-item-288">
            <a href="<?=WEBSITE_URL?>logout">Logout</a>
        </li>
        <?
    }
}