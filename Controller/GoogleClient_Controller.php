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
require_once CONTROLLER_ROOT . 'GoogleAccount_Controller.php';

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
    private $google_client;

    /**
     * @var Google_Oauth2Service
     */
    private $google_oauth;

    /**
     * Link to the Google Analytics Service
     * @var GoogleAnalytics_Controller
     */
    private $google_analytics;

    /**
     * @var GoogleAccount_Model
     */
    private $google_account_model;

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
        $this->google_oauth     = new GoogleOauth2_Controller($this->google_client);

        // Set GoogleAccount_Model
        $this->google_account_model = new GoogleAccount_Model();

        // When this user already has a TOKEN, just refresh it..
        if (isset($_SESSION['token'])) { // extract token from session and configure client
            $this->getRefreshToken(null);
        }
    }

    /**
     * Checks if an accesstoken was set, if not, go get one!
     */
    public function checkAuthentication()
    {
        if (!$this->google_client->getAccessToken())
        {
            $authUrl = $this->google_client->createAuthUrl();
            header("Location: " . $authUrl);
            die;
        }
    }

    /**
     * When we come back from Google we should have an token, go set one!
     */
    public function auth()
    {
        $this->google_client->authenticate();
        $_SESSION['token'] = $this->google_client->getAccessToken();

        $user = $this->google_oauth->google_oauth->userinfo->get();
        $name = (string) filter_var($user['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $email = (string) filter_var($user['email'], FILTER_SANITIZE_EMAIL);
        $refresh_token = $this->getRefreshToken();

        $google_account = $this->google_account_model->getGoogleAccountByEmail($email);

        if (isset($google_account->id) && $google_account->id != 0)
        {
            $this->google_account_model->updateRefreshToken($google_account, $refresh_token);
        }
        else
        {
            $id = $this->google_account_model->addGoogleAccount($name, $email, $refresh_token);
            $google_account = $this->google_account_model->getGoogleAccountById($id);
        }

        return $google_account;
    }

    /**
     * Gets and stores the fresh token
     */
    private function getRefreshToken()
    {
        $token = $_SESSION['token'];
        $this->google_client->setAccessToken($token);
        $jsonObject = json_decode($token);

        // Settings object?
        if ($jsonObject->refresh_token) {
            return $jsonObject->refresh_token;
        }
        return null;
    }

    /**
     * Destroys the current session and logsout the user.
     */
    public function logout()
    {
        unset($_SESSION['token']);
        header("Location: index.php");
    }
}