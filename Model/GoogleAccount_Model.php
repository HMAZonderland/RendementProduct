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
class GoogleAccount_Model
{
    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $refresh_token;

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
        return R::store($model);
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
}