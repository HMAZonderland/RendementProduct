<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-06-13
 * Time: 10:17
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class Order_Model
 */
class Order_Model
{
    /**
     * Adds an order to the database.
     * Products are added seperatly.
     *
     * @param       $marketingchannel_id
     * @param       $webshop_id
     * @param       $shipping_cost
     * @param       $date
     * @param array $products
     */
    public function add($marketingchannel_id, $webshop_id, $shipping_cost, $date, array $products)
    {
        $order = R::dispense('order');
        $order->marketingchannel_id = $marketingchannel_id;
        $order->webshop_id = $webshop_id;
        $order->shipping_costs = $shipping_cost;
        $order->date = $date;
        $order_id = R::store($order);

        foreach ($products as $product)
        {
            $productorder = R::dispense('productorder');
            $productorder->order_id = $order_id;
            $productorder->product_id = $product['product_id'];
            $productorder->quantity = $product['quantity'];
            R::store($productorder);
        }
    }
}
