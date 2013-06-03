<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-06-13
 * Time: 11:01
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class MarketingChannel_Model
 */
class MarketingChannel_Model
{
    /**
     * Finds a marketingchannel by name
     *
     * @param $name
     * @return RedBean_OODBBean
     */
    public function getByName($name)
    {
        return R::findOne(
            'marketingchannel',
            'name = ?',
            array($name)
        );
    }

    /**
     * Adds a marketingchannel object
     *
     * @param $name
     *
     * @return int
     */
    public function add($name)
    {
        $marketingchannel = R::dispense('marketingchannel');
        $marketingchannel->name = $name;
        return R::store($marketingchannel);
    }

    /**
     * Checks if a marketingchannel exsists, if not add it.
     *
     * @param $name
     *
     * @return int|mixed
     */
    public function getIdByName($name)
    {
        $marketingchannel = $this->getByName($name);
        if ($marketingchannel == null)
        {

            return $this->add($name);
        }
        else
        {
            return $marketingchannel->id;
        }
    }
}