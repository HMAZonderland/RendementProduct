<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 27-05-13
 * Time: 14:45
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class GoogleAccount_Model
 */
class GoogleAccount_Model extends Main_Model
{
    /**
     * @param $id
     * @param $name
     * @param $email
     * @param $refresh_token
     *
     * @return int
     */
    public function add($name, $email, $refresh_token)
    {
        $model = R::dispense('googleaccount');
        $model->name = $name;
        $model->email = $email;
        $model->refreshtoken = $refresh_token;
        $id = R::store($model);
        $this->notification->success('Het Google Account is opgeslagen.');
        return $id;
    }

    /**
     * @param $id
     *
     * @return RedBean_OODBBean
     */
    public function getById($id)
    {
        return R::load('googleaccount', $id);
    }

    /**
     * @param $email
     *
     * @return RedBean_OODBBean
     */
    public function getByEmail($email)
    {
        return R::findOne(
            'googleaccount',
             'email = ?',
             array($email)
        );
    }

    /**
     * @param $refresh_token
     * @param $id
     */
    public function updateRefreshToken($google_account, $refresh_token)
    {
        $google_account->refreshtoken = $refresh_token;
        R::store($google_account);
    }

    /**
     * Gets the refreshtoken by webshop_id
     *
     * @param $webshop_id
     *
     * @return RedBean_OODBBean
     */
    public function getRefreshTokenByWebshopId($webshop_id)
    {
        $q =    'SELECT ws.id, ga.refreshtoken AS refreshtoken
                FROM webshop ws, webshopgoogleaccount wsga, googleaccount ga
                WHERE ws.id = wsga.webshop_id
                AND ga.id = wsga.googleaccount_id
                AND ws.id = ' . $webshop_id .'
                ORDER BY ga.id ASC
                LIMIT 0, 1';

        $results = R::getAll($q);
        $result = R::convertToBeans('googleaccount', $results);

        // Ugly buhh return! Not my pride.
        if (isset($result[1]->refreshtoken)) {
            return $result[1]->refreshtoken;
        } else {
            return false;
        }
    }
}