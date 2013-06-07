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
    public $totalProfitArray;

    public function __construct()
    {
        parent::__construct();

        // Select from revenue etc etc.
        $this->notification->warning('Er is nog geen data om berekeningen op uit te voeren.');
    }

    public function getResultsPerMarketingChannel()
    {
        /*
         *  SELECT
            p.name,
            pp.price,
            pp.base_cost,
            pp.tax_amount,
            SUM(po.quantity) as quantity,
            mo.shipping_costs,
            (mo.shipping_costs / SUM(po.quantity)) AS shipping

            FROM
            product p,
            productprice pp,
            magentoorder mo,
            productorder po

            WHERE pp.product_id = p.id
            AND p.id  = po.product_id
            AND mo.id = po.order_id

            GROUP BY name
         */
    }
}

/*
SELECT
mo.id,
mc.name,
po.quantity,
mo.shipping_costs,
p.name,
pp.price,
pp.base_cost,
pp.tax_amount

FROM
magentoorder mo

JOIN marketingchannel mc ON mc.id = mo.marketingchannel_id
JOIN productorder po ON po.magentoorder_id = mo.id
JOIN product p ON p.id = po.product_id
JOIN productprice pp ON pp.product_id = p.id

WHERE
mo.webshop_id = 2

======================================================================================================

SELECT
mc.name,
SUM(DISTINCT(pp.price * po.quantity) + mo.shipping_costs) AS revenue,
SUM(DISTINCT(pp.base_cost + pp.tax_amount) * po.quantity) + mo.shipping_costs AS cost,
SUM(DISTINCT((pp.price - pp.base_cost - pp.tax_amount) * po.quantity) - mo.shipping_costs) AS profit

FROM
magentoorder mo

JOIN marketingchannel mc ON mc.id = mo.marketingchannel_id
JOIN productorder po ON po.magentoorder_id = mo.id
JOIN product p ON p.id = po.product_id
JOIN productprice pp ON pp.product_id = p.id

WHERE
mo.webshop_id = 2

GROUP BY mc.name

======================================================================================================

SELECT
p.name,
pp.price,
pp.base_cost,
pp.tax_amount,
SUM(po.quantity) as hoeveelheid,
SUM(mo.shipping_costs) as verzendkosten,
SUM(pp.price) AS omzet,
SUM(pp.base_cost) AS inkoop,
SUM(pp.tax_amount) AS belasting,
SUM(pp.price - pp.base_cost - pp.tax_amount) AS winst


FROM
magentoorder mo

JOIN marketingchannel mc ON mc.id = mo.marketingchannel_id
JOIN productorder po ON po.magentoorder_id = mo.id
JOIN product p ON p.id = po.product_id
JOIN productprice pp ON pp.product_id = p.id

WHERE
mo.webshop_id = 2

GROUP BY p.name


 */