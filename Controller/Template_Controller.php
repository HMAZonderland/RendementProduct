<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 19:04
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class Template
 *
 * Template class, enables dynamic parsing of objects to *.html.php files.
 */
class Template_Controller
{
    /**
     * @var Template_Model
     */
    private $model;

    /**
     * @param       $file
     * @param array $args
     */
    public function __construct($file, $args = array())
    {
        $this->model = new Template_Model($file, $args);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->model($name);
    }

    /**
     * Includes the needed template file and thus replacing all the vars with values.
     */
    public function render()
    {
        include $this->model->file;
    }
}
?>