<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-06-13
 * Time: 13:38
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class Product_Model
 */
class Product_Model
{
    /**
     * Searches for a product by its SKU and webshop_id
     *
     * @param $product_sku
     * @param $webshop_id
     *
     * @return RedBean_OODBBean
     */
    public function getBySku($product_sku, $webshop_id)
    {
        return R::findOne(
            'product',
            'sku = :sku AND webshop_id = :webshop_id',
            array(
                ':sku'          => $product_sku,
                ':webshop_id'   => $webshop_id
            )
        );
    }

    /**
     * Adds a product
     *
     * @param $product_sku
     * @param $produt_name
     * @param $webshop_id
     *
     * @return mixed
     */
    public function add($product_sku, $product_name, $webshop_id)
    {
        $product = R::dispense('product');
        $product->sku = $product_sku;
        $product->name = $product_name;
        $product->webshop_id = $webshop_id;
        return R::store($product);
    }

    /**
     * Fetches the product_id by its SKU & webshop_id
     *
     * @param $product_sku
     * @param $webshop_id
     *
     * @return mixed
     */
    public function getIdBySku($product_sku, $product_name, $webshop_id)
    {
        $product = $this->getBySku($product_sku, $webshop_id);
        if ($product == null)
        {
            return $this->add($product_sku, $product_name, $webshop_id);
        }
        else
        {
            return $product->id;
        }
    }

    /**
     * Compares the prices of the product in the database and
     * the prices in Magento
     *
     * @param $mProduct (magentoProduct)
     * @param $product_id
     */
    public function verifyPrices($mProduct, $product_id)
    {
        // localProduct
        $lProduct = R::findOne(
            'productprice',
            'product_id = :product_id ORDER BY :sort DESC LIMIT 1',
            array(
                ':product_id' => $product_id,
                ':sort' => 'date'
            )
        );

        // If this product does not exsist, just add the prices right away.
        if ($lProduct == null)
        {
            $this->addPrice($mProduct, $product_id);
        }
        else
        {
            // Check if the product prices need an update
            $update = (
                !($lProduct->price        == (double) round($mProduct['price'], 2))        ||
                !($lProduct->base_cost    == (double) round($mProduct['base_cost'], 2))    ||
                !($lProduct->tax_amount   == (double) round($mProduct['tax_amount'],2))
            );

            if ($update)
            {
                // Update the prices
                $this->addPrice($mProduct, $product_id);
            }
        }
    }

    /**
     * Stores the prices of a product
     *
     * @param $mProduct
     * @param $product_id
     */
    public function addPrice($mProduct, $product_id)
    {
        $productprice = R::dispense('productprice');
        $productprice->product_id = $product_id;
        $productprice->price = $mProduct['price'];
        $productprice->base_cost = $mProduct['base_cost'];
        $productprice->tax_amount = $mProduct['tax_amount'];
        $productprice->date = $mProduct['created_at'];
        R::store($productprice);
    }
}