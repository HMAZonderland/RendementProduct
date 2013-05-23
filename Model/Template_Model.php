<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 23-05-13
 * Time: 15:01
 * To change this template use File | Settings | File Templates.
 */

class Template_Model
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
}