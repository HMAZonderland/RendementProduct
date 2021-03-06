<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 16:16
 * Main controller, creates instances and loads other controllers.
 */
require_once CONTROLLER_ROOT . 'View_Controller.php';
require_once MODEL_ROOT . 'Main_Model.php';

require_once CONTROLLER_ROOT . 'GoogleClient_Controller.php';
require_once MODEL_ROOT . 'Webshop_Model.php';
/**
 * Class Controller
 */
class Main_Controller extends View_Controller
{
    /**
     * @var
     */
    public $google_client;

    /**
     * @var
     */
    public $google_account;

    /**
     * Default constructor
     */
    public function init()
    {
        $this->google_client = new GoogleClient_Controller();
        if (!isset($_GET['code'])) $this->checkAuthentication(); // dirty redirect loop fix..
    }

    /**
     * Includes the needed controller and creates an instance of this controller
     *
     * @param $controller
     *
     * @return mixed
     */
    public function loadController($controller)
    {
        // Load the class needed
        $filepath = CONTROLLER_ROOT . $controller . ".php";
        if (file_exists($filepath))
        {
            include $filepath;

            // Create an instance of this class
            return $this->createInstance($controller);
        }
        else
        {
            echo "Could not load requested Controller: " . $filepath . "<br />The controller file was not found.";
            die();
        }
    }

    /**
     * Creates an instance of the controller
     *
     * @param $controller
     *
     * @return mixed
     */
    private function createInstance($controller)
    {
        return $controller = new $controller();
    }

    /**
     * Index function
     */
    public function index()
    {
        $model = new Main_Model();
        $this->parse($model);
    }

    /**
     * Not found function
     */
    public function not_found()
    {
        $model = new Main_Model();
        $this->parse($model);
    }

    /**
     * Checks the current session
     */
    public function checkAuthentication()
    {
        $this->google_account = $this->google_client->checkAuthentication();
    }

    /**
     * Authenticates a Google Account
     */
    public function auth()
    {
        $this->google_client->auth();
        header('Location: ' . WEBSITE_URL . 'dashboard');
    }

    /**
     * Logsout the current user.
     */
    public function logout()
    {
        $this->google_client->logout();
    }

    /**
     * Show settings page.
     */
    public function settings()
    {
        $webshop_model = new Webshop_Model();
        $webshop_model->webshops = $webshop_model->getWebshopByEmail($this->google_account->email);
        $this->parse($webshop_model);
    }
}