<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Bullmkt
 * @package     Bullmkt_ShippingTips
 * @copyright   Copyright (c) 2013 Bull Marketing <http://www.bullmarketing.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      Leandro Rosa <dev.leandrorosa@gmail.com>
 * @author      Tiago Silva <tg.solucoesweb@gmail.com>
 *
 */

class Bullmkt_ShippingTips_Model_Tips extends Mage_Core_Model_Abstract
{
    public function getProducts($price)
    {
        $price = $price + \Mage::getStoreConfig('bullmkt/shippingtips/increase_range_product_price', Mage::app()->getStore());
        
        $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect(array('price', 'special_price', 'name','thumbnail','visibility','sku'))
                ->addAttributeToFilter('price', array('lteq' => $price))
                ->addAttributeToFilter('visibility', array('in' => array(2,4)));
        
        $collection->getSelect()->joinLeft(
            array('_inventory_table' => $collection->getTable('cataloginventory/stock_item')),
            '_inventory_table.product_id = e.entity_id',
            array('enable_qty_increments', 'qty_increments', 'qty', 'is_in_stock')
        );
        
        $limit = Mage::getStoreConfig('bullmkt/shippingtips/products_limit', Mage::app()->getStore());

        if($limit)
            $collection->getSelect()->limit($limit);

        return $collection;
    }
}