<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 28-05-13
 * Time: 10:32
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class Webshop_Model
 */
class Webshop_Model extends Main_Model
{
    /**
     * @var
     */
    public $webshops = array();

    /**
     * @param $email
     *
     * @return array
     */
    public function getWebshopByEmail($email)
    {
        $q =
            'SELECT ws.id, ws.name, ga.email, ws.ga_profile
            FROM webshop ws, webshopgoogleaccount wsga, googleaccount ga
            WHERE ws.id = wsga.webshop_id
            AND ga.id = wsga.googleaccount_id
            AND ga.email = \'' . $email .'\'';

        $result = R::getAll($q);
        $webshops = R::convertToBeans('webshop', $result);

        foreach ($webshops as $webshop)
        {
            array_push($this->webshops, $webshop);
        }
    }

    /**
     * Returns all webshops from the database
     * @return array
     */
    public function getAll()
    {
        return R::findAll('webshop');
    }

    /**
     * @param $id
     *
     * @return RedBean_OODBBean
     */
    public function getById($id)
    {
        return R::findOne(
            'webshop',
            'id = ?',
            array(
                $id
            )
        );
    }
}