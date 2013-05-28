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
            '
            SELECT
            ws.id AS id,
            ws.name AS name,
            ws.URL as URL

            FROM webshop ws, webshopgooleaccount wsga

            WHERE wsga.email = \'' . $email . '\'';

        Debug::s($q);

        $result = R::getAll($q);

        return R::convertToBeans('webshop', $result);
    }
}