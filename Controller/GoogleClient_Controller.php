<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 17:29
 * This class is used for various Google (OAuth) functions.
 * It fetches an access token and refreshes the exsisting refresh token.
 */

require_once CONTROLLER_ROOT . 'GoogleAnalytics_Controller.php';

/**
 * Class GoogleClient_Controller
 */
class GoogleClient_Controller
{
    /**
     * @var Google_Client
     */
    private $google_client;

    private $google_analytics;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->google_client = new Google_Client(); // GoogleClient init
        $this->google_client->setAccessType(ACCESS_TYPE); // default: offline
        $this->google_client->setApplicationName(APPLICATION_NAME); // Title
        $this->google_client->setClientId(CLIENT_ID); // ClientId
        $this->google_client->setClientSecret(CLIENT_SECRET); // ClientSecret
        $this->google_client->setRedirectUri(REDIRECT_URI); // Where to redirect to after authentication
        $this->google_client->setDeveloperKey(DEVELOPER_KEY); // Developer key

        $this->google_analytics = new GoogleAnalytics_Controller($this->google_client);

        Debug::s('Google Client Lib geladen!');

        if (isset($_SESSION['token'])) { // extract token from session and configure client
            $this->getRefreshToken();
        }
    }

    /**
     * Checks if an accesstoken was set, if not, go get one!
     */
    public function checkAuthentication(array $params)
    {
        Debug::s('Google Client Lib checkAuthentication!');
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

        $this->getRefreshToken();
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
            Debug::p($jsonObject);
        }
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