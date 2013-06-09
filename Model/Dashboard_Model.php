<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 30-05-13
 * Time: 15:51
 * To change this template use File | Settings | File Templates.
 */

class Dashboard_Model extends Main_Model
{
    /**
     * @var array
     */
    public $results_per_marketingchannel = array();

    /**
     * total websho revenue
     * @var
     */
    public $total_revenue;

    /**
     * webshop cost
     * @var
     */
    public $webshop_cost;

    /**
     * Calculates revenue, profit and grossprofit per marketingchannel
     * This does NOT include marketingchannelcost and webshop cost
     *
     * @param $webshop_id
     */
    public function getResultsPerMarketingChannel($webshop_id)
    {
        // TODO: time filter => month, week, day
        $q =
            '
             SELECT
            mc.id as id,
            mc.name as marketingchannel,
            ROUND(SUM((pp.price + pp.tax_amount) * po.quantity) + SUM(mo.shipping_costs) , 2) as revenue,
            ROUND(SUM((pp.base_cost + pp.tax_amount) * po.quantity), 2) + SUM(mo.shipping_costs) as costs,
            ROUND(SUM((pp.price + pp.tax_amount - pp.tax_amount - pp.base_cost) * po.quantity), 2) as grossprofit,
            mcc.cost as marketingchannelcost

            FROM
            product p

            JOIN productprice pp ON pp.product_id = p.id
            JOIN productorder po ON po.product_id = p.id
            JOIN magentoorder mo ON mo.id = po.magentoorder_id AND mo.webshop_id = p.webshop_id
            JOIN marketingchannel mc ON mc.id = mo.marketingchannel_id
            LEFT JOIN marketingchannelcost mcc ON mcc.marketingchannel_id = mo.marketingchannel_id

            WHERE
            p.webshop_id = ' . $webshop_id . '

            GROUP BY mc.name';

        // Data
        $rows = R::getAll($q);
        $markingtingchannls = R::convertToBeans('resultspermarketingchannel', $rows);

        foreach ($markingtingchannls as $marketingchannel)
        {
            array_push($this->results_per_marketingchannel, $marketingchannel);
        }
    }

    /**
     * Gets the total revenue of a marketingchannel
     *
     * @param $webshop_id
     */
    public function getTotalRevenue($webshop_id)
    {
        $q =
            'SELECT

            p.id,
            ROUND(SUM((pp.price + pp.tax_amount) * po.quantity), 2) + mo.shipping_costs as revenue

            FROM
            product p

            JOIN productprice pp ON pp.product_id = p.id
            JOIN productorder po ON po.product_id = p.id
            JOIN magentoorder mo ON mo.id = po.magentoorder_id AND mo.webshop_id = p.webshop_id

            WHERE
            p.webshop_id = ' . $webshop_id;

        $rows = R::getAll($q);

        // Extract data
        $results = R::convertToBeans('totalrevenue', $rows);

        foreach ($results as $result) {
            $this->total_revenue = $result->revenue;
        }

        return;
    }

    /**
     * Gets the cost of the webshop per month
     *
     * @param $webshop_id
     */
    public function getWebshopCosts($webshop_id)
    {
        $data = R::findOne(
            'webshopcost',
            'webshop_id = ? ORDER BY date ASC LIMIT 1',
            array(
                $webshop_id
            )
        );
        $this->webshop_costs = $data->cost;
    }
}

/*
Debug queries

SELECT
p.id,
p.name,
pp.price,
pp.base_cost,
pp.tax_amount,
SUM(po.quantity) as hoeveelheid,
SUM(pp.price * po.quantity) as omzet,
SUM((pp.base_cost + pp.tax_amount) * po.quantity) as kosten,
SUM((pp.price - pp.base_cost - pp.tax_amount) * po.quantity) as winst

FROM
product p

JOIN productprice pp ON pp.product_id = p.id
JOIN productorder po ON po.product_id = p.id

WHERE
webshop_id = 2

GROUP BY p.name
 */