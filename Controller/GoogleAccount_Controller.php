<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 27-05-13
 * Time: 15:04
 * To change this template use File | Settings | File Templates.
 */

require_once MODEL_ROOT . 'GoogleAccount_Model.php';

/**
 * Class GoogleAccount_Controller
 */
class GoogleAccount_Controller
{
    /**
     * @param $id
     * @param $name
     * @param $email
     * @param $refresh_token
     *
     * @return mixed
     */
    public function addGoogleAccount($name, $email, $refresh_token)
    {
        $model = new GoogleAccount_Model();
        return $model->add($name, $email, $refresh_token);
    }

    /**
     * @param $id
     *
     * @return RedBean_OODBBean
     */
    public function getGoogleAccountById($id)
    {
        $model = new GoogleAccount_Model();
        return $model->getById($id);
    }

    /**
     * @param $email
     *
     * @return RedBean_OODBBean
     */
    public function getGoogleAccountByEmail($email)
    {
        $model = new GoogleAccount_Model();
        return $model->getByEmail($email);
    }

    /**
     * @param $id
     * @param $refresh_token
     */
    public function updateRefreshToken($google_account, $refresh_token)
    {
        $model = new GoogleAccount_Model();
        $model->updateRefreshToken($google_account, $refresh_token);
    }
}