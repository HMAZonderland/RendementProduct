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

    public function getMarketingChannelAndCostByName($name)
    {
        $q =
            '
            SELECT
            mc.id AS id,
            mc.name AS name,
            mcc.cost AS cost

            FROM
            marketingchannel mc

            JOIN
            marketingchannelcost mcc ON mcc.marketingchannel_id = mc.id

            WHERE
            mc.name = \'' . $name . '\'';

        $rows = R::getAll($q);
        $marketingchannels = R::convertToBeans('marketingchannelcost', $rows);

        $tmp = array();

        // Pushes the found products into the local array which will be sent on to the view
        foreach ($marketingchannels as $marketingchannel)
        {
            array_push($tmp, $marketingchannel);
        }

        if (array_key_exists(0, $tmp))
        {
            return $tmp[0];
        }
        return null;
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

    /**
     * Gets all marketingchannels
     *
     * @return array
     */
    public function getAll()
    {
        return R::findAll('marketingchannel');
    }
}