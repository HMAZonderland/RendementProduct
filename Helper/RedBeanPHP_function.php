<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 22-05-13
 * Time: 23:51
 * To change this template use File | Settings | File Templates.
 */

class RedBeanModelFormatter implements RedBean_IModelFormatter
{
    public function formatModel($model)
    {
        return $model . '_Model';
    }
}

RedBean_ModelHelper::setModelFormatter(new RedBeanModelFormatter());
?>