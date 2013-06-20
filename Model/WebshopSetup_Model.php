<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 29-05-13
 * Time: 15:44
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class WebshopSetup_Model
 */
class WebshopSetup_Model extends Main_Model
{
    /**
     * @var array
     */
    public $google_analytics_profiles = array();

    /**
     * @param $post_data
     * @param $googleaccount_id
     */
    public function save($post_data, $googleaccount_id)
    {
        /*
         * TODO: propper validation
         * 1. check if the URL is valid
         * 2. check if the URL does not already exsist in the database
         * 3. add the website URL form the Google Analytics profile and compare this with the Magento URL
         * these should be the same (domain)
         * 4. validate the input (strings etc)
         */
        $webshop_name   =   $post_data['webshop_name'];

        $ga_profile     =   $post_data['hid_profile'];
        $ga_property    =   $post_data['hid_property'];
        $ga_account     =   $post_data['hid_account'];

        $magento_host   =   $post_data['magento_host'];
        $magento_user   =   $post_data['magento_user'];
        $magento_key    =   $post_data['magento_key'];

        $webshop_id = $this->create_webshop($webshop_name, $ga_profile, $ga_property, $ga_account, $magento_host, $magento_user, $magento_key);

        $this->createOrUpdate_analytics($googleaccount_id, $webshop_id);

        $this->notification->success('De webshop is toegevoegd.');
    }

    /**
     * @param $googleaccount_id
     * @param $webshop_id
     */
    public function createOrUpdate_analytics($googleaccount_id, $webshop_id)
    {
        $webshop_google_account = R::dispense('webshopgoogleaccount');
        $webshop_google_account->webshop_id = $webshop_id;
        $webshop_google_account->googleaccount_id = $googleaccount_id;
        R::store($webshop_google_account);
    }

    /**
     * @param $webshop_name
     * @param $ga_profile
     * @param $ga_property
     * @param $ga_account
     * @param $magento_host
     * @param $magento_user
     * @param $magento_key
     * @return int
     */
    public function create_webshop($webshop_name, $ga_profile, $ga_property, $ga_account, $magento_host, $magento_user, $magento_key)
    {
        $webshop = R::dispense('webshop');
        $webshop->name = $webshop_name;
        $webshop->ga_profile = $ga_profile;
        $webshop->ga_property = $ga_property;
        $webshop->ga_account = $ga_account;
        $webshop->magento_host = $magento_host;
        $webshop->magento_user = $magento_user;
        $webshop->magento_key = $magento_key;

        $webshop_id = R::store($webshop);
        return $webshop_id;
    }
}
