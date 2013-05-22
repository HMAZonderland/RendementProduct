<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 19:04
 * To change this template use File | Settings | File Templates.
 */

class Template
{
    private $args;
    private $file;

    public function __get($name)
    {
        return $this->args[$name];
    }

    public function __construct($file, $args = array())
    {
        $this->file = $file;
        $this->args = $args;
    }

    public function render()
    {
        include $this->file;
    }
}
?>