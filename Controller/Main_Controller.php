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
/**
 * Class Controller
 */
class Main_Controller extends View_Controller
{
    /**
     * @var void
     */
    private $db;

    /**
     * Default constructor, loads the Database_Controller
     */
    public function __construct()
    {
        $this->db = R::setup('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', '' . DB_USERNAME . '', '' . DB_PASS . '');
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
}