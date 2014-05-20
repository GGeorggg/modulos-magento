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
class Magentando_SplitDelivery_Block_Adminhtml_Sales_Order_View_Tab_Items extends Mage_Adminhtml_Block_Sales_Order_Abstract
implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getSplitDelivery()
    {
        $splitDeliveryItems = Mage::helper('core')->jsonDecode($this->getOrder()->getSplitdelivery());
        $itemsCollection = array();

        foreach ($splitDeliveryItems as $items) {
            $itemsCollection[] = Mage::helper('core')->jsonDecode($items);
        }

        return $itemsCollection;
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('magentando/splitdelivery/items.phtml');
    }

    /**
     * Retrieve order model instance
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return Mage::registry('current_order');
    }

    /**
     * Retrieve source model instance
     *
     * @return Mage_Sales_Model_Order
     */
    public function getSource()
    {
        return $this->getOrder();
    }

    public function getTabLabel()
    {
        return Mage::helper('sales')->__('Split Delivery');
    }

    public function getTabTitle()
    {
        return Mage::helper('sales')->__('Split Delivery');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
