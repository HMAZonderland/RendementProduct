<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 29-05-13
 * Time: 15:44
 * To change this template use File | Settings | File Templates.
 */

class WebshopSetup_Model extends Main_Model
{
    /**
     * @var array
     */
    public $google_analytics_profiles = array();

    /**
     * @param $_POST
     */
    public function save($post_data, $googleaccount_id)
    {
        // TODO: propper validation
        $webshop_name   =   $post_data['webshop_name'];

        $ga_profile     =   $post_data['hid_profile'];
        $ga_property    =   $post_data['hid_property'];
        $ga_account     =   $post_data['hid_account'];

        $magento_host   =   $post_data['magento_host'];
        $magento_user   =   $post_data['magento_user'];
        $magento_key    =   $post_data['magento_key'];

        $webshop                = R::dispense('webshop');
        $webshop->name          = $webshop_name;
        $webshop->ga_profile    = $ga_profile;
        $webshop->ga_property   = $ga_property;
        $webshop->ga_account    = $ga_account;
        $webshop->magento_host  = $magento_host;
        $webshop->magento_user  = $magento_user;
        $webshop->magento_key   = $magento_key;

        $webshop_id = R::store($webshop);

        $webshop_google_account                     = R::dispense('webshopgoogleaccount');
        $webshop_google_account->webshop_id         = $webshop_id;
        $webshop_google_account->googleaccount_id   = $googleaccount_id;
        R::store($webshop_google_account);

        $this->notification->success('De webshop is toegevoegd.');
    }
}
