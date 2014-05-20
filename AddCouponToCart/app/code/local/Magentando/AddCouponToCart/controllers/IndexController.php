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
* @package     Magentando_AddCouponToCart
* @copyright   Copyright (c) 2014 Magentando <http://www.magentando.com.br>
* @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* @author      Leandro Rosa <dev.leandrorosa@gmail.com>
*
*/
class Magentando_AddCouponToCart_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();
        if (isset($params['qty'])) {
            $qty = $params['qty'];
        } else {
            $qty = 1;
        }
        $product = Mage::getModel('catalog/product')->load($params['product']);
        $cartParams = array(
            'product' => $params['product'],
            'qty' => $qty,
        );

        $cart = Mage::getSingleton('checkout/cart');
        $cart->init()
            ->addProduct($product, $cartParams)
            ->save()
            ->getQuote()
            ->setCouponCode($params['coupon'])
            ->collectTotals()
            ->save();

        Mage::getSingleton('checkout/session')->setCartWasUpdated(true);

        $this->_redirect('checkout/cart');
    }
}