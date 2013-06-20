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
            '
            SELECT
            ws.id,
            ws.name,
            ga.email,
            ws.ga_profile

            FROM googleaccount ga

            JOIN webshopgoogleaccount wsga ON wsga.googleaccount_id = ga.id
            JOIN webshop ws ON ws.id = wsga.webshop_id

            WHERE
            ga.email = \'' . $email .'\'';

        $result = R::getAll($q);
        $webshops = R::convertToBeans('webshop', $result);
        $temp_array = array();

        foreach ($webshops as $webshop)
        {
            array_push($temp_array, $webshop);
        }

        return $temp_array;
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
        /*return R::findOne(
            'webshop',
            'id = ?',
            array(
                $id
            )
        );*/
        return R::load('webshop', $id);
    }

    /**
     * @param $webshop_id
     * @param $email
     *
     * @return bool
     */
    public function hasAccess($webshop_id, $email)
    {
        $webshops = $this->getWebshopByEmail($email);
        $has_access = false;
        foreach ($webshops as $webshop)
        {
            if ($webshop->id == $webshop_id)
            {
                $has_access = true;
            }
        }
        return $has_access;
    }
}