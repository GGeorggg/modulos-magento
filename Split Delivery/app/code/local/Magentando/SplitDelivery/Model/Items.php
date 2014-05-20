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
 * @category    Magentando
 * @package     Magentando_SplitDelivery
 * @copyright   Copyright (c) 2014 Magentando <http://www.magentando.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      Leandro Rosa <dev.leandrorosa@gmail.com>
 *
 */
class Magentando_SplitDelivery_Model_Items extends Mage_Core_Model_Abstract
{
    protected static $_category;

    public function __construct()
    {
        $categoyId = Mage::getStoreConfig('shipping/splitdelivery/category');

        if (!self::$_category) {
            self::$_category = Mage::getModel('catalog/category')
                ->load($categoyId);
        }
    }

    public function getItems()
    {
        $items = array();
        foreach ($this->_getItems() as $item) {
            foreach ($this->_getCartItems() as $cartItem) {
                if ($item->getId() == $cartItem['id']) {
                    for ($i=1; $i <= $cartItem['qty']; $i++) {
                        $items[] = $item;
                    }
                }
            }
        }

        return $items;
    }

    protected function _getItems()
    {
        $productsCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter(
                'entity_id', array(
                    'in' => $this->_getCartItemsIds()
                )
            )
            ->addCategoryFilter(self::$_category);

        return $productsCollection;
    }

    protected function _getCartItems()
    {
        $items = Mage::getSingleton('checkout/cart')->getQuote()
            ->getAllVisibleItems();

        $cartItems = array();
        foreach ($items as $item) {
            $cartItems[] = array(
                'id' => $item->getProductId(),
                'qty' => $item->getQty()
            );
        }

        return $cartItems;
    }

    protected function _getCartItemsIds()
    {
        $itemsIds = array();

        foreach ($this->_getCartItems() as $item) {
            $itemsIds[] = $item['id'];
        }

        return $itemsIds;
    }

    public function setQuoteSplitDeliveryItems($splitDeliveryItems)
    {
        $quote = Mage::getModel('checkout/cart')->getQuote();
        $quote->setSplitdelivery($splitDeliveryItems);
        $quote->save();
    }
}
