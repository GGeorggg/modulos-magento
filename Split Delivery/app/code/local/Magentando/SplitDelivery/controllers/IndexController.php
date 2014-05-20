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

class Magentando_SplitDelivery_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $qtyPeople = $this->getRequest()
            ->getPost('qty-people');

        $currentday = $this->getRequest()
            ->getPost('delivery-day');

        $month =  (int) substr("$currentday", 3, 5);
        $day =  (int) substr("$currentday", 0, 2);
        $deliveryDay = date("d/m", mktime(0, 0, 0, $month, $day));

        Mage::getSingleton('core/session')->setQtyPeople($qtyPeople);
        Mage::getSingleton('core/session')->setDeliveryDay($deliveryDay);

        $this->_redirect('checkout/cart');
        return;
    }
}