<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 27-05-13
 * Time: 13:58
 * To change this template use File | Settings | File Templates.
 */

class GoogleOauth2_Controller
{
    /**
     * @var Google_Oauth2Service
     */
    public $google_oauth;

    /**
     * @param $google_client
     */
    public function __construct($google_client)
    {
        $this->google_oauth = new Google_Oauth2Service($google_client);
    }
}