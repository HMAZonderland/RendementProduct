<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 28-05-13
 * Time: 10:32
 * To change this template use File | Settings | File Templates.
 */

class Webshop_Model
{
    public function getWebshopByEmail($email)
    {
        $q =
            'SELECT ws.id, ws.name, ga.email
            FROM webshop ws, webshopgoogleaccount wsga, googleaccount ga
            WHERE ws.id = wsga.webshop_id
            AND ga.id = wsga.googleaccount_id
            AND ga.email = \'' . $email .'\'';
        $result = R::getAll($q);
        return R::convertToBeans('webshop', $result);
    }
}