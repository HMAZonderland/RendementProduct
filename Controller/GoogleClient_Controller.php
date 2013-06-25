<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 17:29
 * This class is used for various Google (OAuth) functions.
 * It fetches an access token and refreshes the exsisting refresh token.
 */

// Controllers
require_once CONTROLLER_ROOT . 'GoogleAnalytics_Controller.php';
require_once CONTROLLER_ROOT . 'GoogleOauth2_Controller.php';

// Models
require_once MODEL_ROOT . 'GoogleAccount_Model.php';

/**
 * Class GoogleClient_Controller
 */
class GoogleClient_Controller
{
    /**
     * @var Google_Client
     */
    public $google_client;

    /**
     * @var Google_Oauth2Service
     */
    public $google_oauth;

    /**
     * Link to the Google Analytics Service
     * @var GoogleAnalytics_Controller
     */
    public $google_analytics;

    /**
     * @var GoogleAccount_Model
     */
    public $google_account_model;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Setup the Google Client
        $this->google_client = new Google_Client(); // GoogleClient init
        $this->google_client->setAccessType(ACCESS_TYPE); // default: offline
        $this->google_client->setApplicationName(APPLICATION_NAME); // Title
        $this->google_client->setClientId(CLIENT_ID); // ClientId
        $this->google_client->setClientSecret(CLIENT_SECRET); // ClientSecret
        $this->google_client->setRedirectUri(REDIRECT_URI); // Where to redirect to after authentication
        $this->google_client->setDeveloperKey(DEVELOPER_KEY); // Developer key

        // Set services..
        $this->google_analytics = new GoogleAnalytics_Controller($this->google_client);
        $this->google_oauth = new GoogleOauth2_Controller($this->google_client);

        // Set GoogleAccount_Model
        $this->google_account_model = new GoogleAccount_Model();
    }

    /**
     * Checks if an $_SESSION was set, if not, go get one!
     */
    public function checkAuthentication() {
        if(isset($_SESSION['token'])) {
            $this->google_client->setAccessToken($_SESSION['token']);
            return $google_account = $this->getGoogleAccount();
        } else if(isset($_COOKIE['refresh_token']) && !empty($_COOKIE['refresh_token'])) {
            $refresh_token = $_COOKIE['refresh_token'];
            $this->google_client->refreshToken($refresh_token);
           return $this->getGoogleAccount();
        } else {
            $this->authenticate();
        }
    }

    /**
     * Sends the user to the Google Authenication page.
     */
    private function authenticate()
    {
        $authUrl = $this->google_client->createAuthUrl();
        header('Location: ' . $authUrl);
        die;
    }

    /**
     * When we come back from Google we should have an token, go set one!
     */
    public function auth()
    {
        // Authenticate the Google Client and set the TOKEN in session
        $this->google_client->authenticate();
        $_SESSION['token'] = $this->google_client->getAccessToken();

        // Gets the (new) Google Account
        $google_account = $this->getGoogleAccount();

        // Return the account
        return $google_account;
    }

    /**
     *
     */
    public function getGoogleAccount()
    {
        if ($this->google_client->getAccessToken()) {
            // Extract user variables
            $user = $this->google_oauth->google_oauth->userinfo->get();
            $name = (string)filter_var($user['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $email = (string)filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $refresh_token = $this->getRefreshToken($this->google_client->getAccessToken());
            $google_account = $this->getGoogleAccountByEmail($email);

            // When we find something, refresh his token
            if (isset($google_account->id) && $google_account->id != 0 && !empty($refresh_token)) {
                // update the refresh token
                $this->google_account_model->updateRefreshToken($google_account, $refresh_token);

                // set a cookie with the refresh token for 30 days
                setcookie('refresh_token', $refresh_token, time() + 60 * 60 * 24 * 30, '/');
            } // If we do not find anything this means we have to add this user to our database
            else if ($google_account->id == 0) {
                $id = $this->google_account_model->add($name, $email, $refresh_token);
                $google_account = $this->google_account_model->getById($id);
            }

            return $google_account;
        } else {
            return null;
        }
    }

    /**
     * @param $email
     *
     * @return RedBean_OODBBean
     */
    public function getGoogleAccountByEmail($email)
    {
        return $google_account = $this->google_account_model->getByEmail($email);
    }

    /**
     * Gets and stores the fresh token
     */
    private function getRefreshToken($token)
    {
        $jsonObject = json_decode($token);

        if (!empty($jsonObject->refresh_token)) {
            return $jsonObject->refresh_token;
        }
    }

    /**
     * Destroys the current session and logsout the user.
     */
    public function logout()
    {
        unset($_SESSION['token']);
        setcookie('refresh_token', '', time() + 30, '/');
        header("Location: index.php");
    }
}