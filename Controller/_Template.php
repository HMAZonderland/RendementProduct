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
class Template
{
    /**
     * Object variables
     * @var array
     */
    private $args;

    /**
     * Template file
     * @var
     */
    private $file;

    /**
     * @param       $file
     * @param array $args
     */
    public function __construct($file, $args = array())
    {
        $this->file = $file;
        $this->args = $args;
    }

    /**
     * Gets an object variable
     *
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->args[$name];
    }

    /**
     * Includes the needed template file and thus replacing all the vars with values.
     */
    public function render()
    {
        include $this->file;
    }
}
?>