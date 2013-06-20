<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-06-13
 * Time: 15:15
 * To change this template use File | Settings | File Templates.
 */

class ChannelDashboard_Model
{
    /**
     * @var array
     */
    public $products_per_marketingchannel = array();

    /**
     * @var
     */
    public $sold_products;

    /**
     * @var
     */
    public $webshop_costs;

    /**
     * @var
     */
    public $ratio;

    /**
     * Fetches the products sold trough the given marketingchannel and webshop.
     * It calculates the revenue made, the total cost (except for marketingchannel cost and webshopcosts, these are added later.
     *
     * @param $webshop_id
     * @param $marketingchannel_id
     */
    public function productsByMarketingChannelAndWebshopId($webshop_id, $marketingchannel_id)
    {
        $q =
            'SELECT
            p.id,
            p.name AS name,
            pp.price as price,
            pp.base_cost as base_cost,
            pp.tax_amount as tax_amount,
            SUM(po.quantity) as quantity,
            SUM(mo.shipping_costs / (SELECT SUM(quantity) FROM productorder WHERE magentoorder_id = mo.id)) / po.quantity as shipping_costs,
            ROUND(SUM((pp.price + pp.tax_amount) * po.quantity) + SUM((mo.shipping_costs / (SELECT SUM(quantity) FROM productorder WHERE magentoorder_id = mo.id)) / po.quantity) , 2) as revenue,
            ROUND(SUM((pp.base_cost + pp.tax_amount) * po.quantity) + SUM((mo.shipping_costs / (SELECT SUM(quantity) FROM productorder WHERE magentoorder_id = mo.id)) / po.quantity), 2) as costs,
            ROUND(SUM(pp.price + pp.tax_amount - pp.tax_amount - pp.base_cost * po.quantity), 2) as grossprofit

            FROM magentoorder mo

            JOIN productorder po ON po.magentoorder_id = mo.id
            JOIN product p ON p.id = po.product_id
            JOIN productprice pp ON pp.product_id = p.id

            WHERE
            mo.webshop_id = ' . $webshop_id . ' AND
            mo.marketingchannel_id = ' . $marketingchannel_id . ' AND
            pp.date = mo.date


            GROUP BY
            p.name';

        Debug::p($q);

        // Data
        $rows = R::getAll($q);
        $products = R::convertToBeans('productresults', $rows);

        // Pushes the found products into the local array which will be sent on to the view
        foreach ($products as $product)
        {
            array_push($this->products_per_marketingchannel, $product);
        }
    }

    /**
     * Fetches and calculates how many products where sold trough a marketingchannel
     *
     * @param $webshop_id
     * @param $marketingchannel_id
     */
    public function soldproducts($webshop_id, $marketingchannel_id)
    {
        $q =
            'SELECT
            po.id, SUM(po.quantity) as quantity

            FROM
            productorder po

            JOIN magentoorder mo ON po.magentoorder_id = mo.id

            WHERE
            mo.marketingchannel_id = ' . $marketingchannel_id .  ' AND
            mo.webshop_id = ' . $webshop_id;

        // Data
        $rows = R::getAll($q);
        $results = R::convertToBeans('productquantity', $rows);

        // There will be 1 result only, but still get fetched as array
        // TODO:: other query type, see RedBeanPHP documentation
        foreach ($results as $result)
        {
            $this->sold_products = $result->quantity;
        }
    }

    /**
     * Determens how much the revenue ratio is this marktingchannel has generated
     *
     * @param $webshop_id
     * @param $marketingchannel_id
     */
    public function ratio($webshop_id, $marketingchannel_id)
    {
        $q =
            'SELECT
            p.id,
            ROUND(SUM((pp.price + pp.tax_amount) * po.quantity), 2) + mo.shipping_costs as total,
            (
                SELECT
                ROUND(SUM((pp.price + pp.tax_amount) * po.quantity), 2) + mo.shipping_costs
                FROM
                product p

                JOIN productprice pp ON pp.product_id = p.id
                JOIN productorder po ON po.product_id = p.id
                JOIN magentoorder mo ON mo.id = po.magentoorder_id AND mo.webshop_id = p.webshop_id

                WHERE
                p.webshop_id = ' . $webshop_id . ' AND mo.marketingchannel_id = ' . $marketingchannel_id . '
            ) as marketingchannel_revenue

            FROM
            product p

            JOIN productprice pp ON pp.product_id = p.id
            JOIN productorder po ON po.product_id = p.id
            JOIN magentoorder mo ON mo.id = po.magentoorder_id AND mo.webshop_id = p.webshop_id

            WHERE
            p.webshop_id = ' . $webshop_id;

        // Data
        $rows = R::getAll($q);
        $results = R::convertToBeans('revenueratio', $rows);

        // There will be 1 result only, but still get fetched as array
        // TODO:: other query type, see RedBeanPHP documentation
        foreach ($results as $result)
        {
            $this->ratio = $result->marketingchannel_revenue / $result->total;
        }
    }
}
/*
SELECT p.name, p.sku, pp.price, pp.base_cost, pp.tax_amount, SUM( po.quantity ) hoeveelheid, pp.date AS prijsdatum
FROM productorder po
JOIN product p ON p.id = po.product_id
JOIN productprice pp ON pp.product_id = po.product_id
GROUP BY pp.date, p.name
ORDER BY p.name
 */