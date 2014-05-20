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
 * @package     Bullmkt_RedirectLogin
 * @copyright   Copyright (c) 2013 Bull Marketing <http://www.bullmarketing.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * 
 * @author		Leandro Rosa <dev.leandrorosa@gmail.com>
 */
 
class Bullmkt_RedirectLogin_Model_Observer
{
	/*
	 * Create session in checkout
	 * if customer not logged in
	 *
	 * @return bool
	 */
    public function hasCheckoutCartSession($observer = null)
    {
		if(Mage::helper('customer')->isLoggedIn() || Mage::getSingleton('core/session')->getIsNewCustomer()  )
		{
			Mage::getSingleton('core/session')->setIsNewCustomer('');
			Mage::getSingleton('core/session')->setIsCheckoutCart('');
			return;
		}
		Mage::getSingleton('core/session')->setIsCheckoutCart(true);
		$session = Mage::getSingleton('core/session')->getIsCheckoutCart();
		
		return $session;
    }

	public function isNewCustomer()
	{
		
		Mage::getSingleton('core/session')->setIsNewCustomer(true);
		$session = Mage::getSingleton('core/session')->getIsNewCustomer();
		
		return $session;
	}
	
	public function redirectLogin($observer = null)
	{
		
		if ($this->hasCheckoutCartSession())
		{
			Mage::getSingleton('core/session')->setGoBackCart(true);
			Mage::app()->getResponse()->setRedirect('../customer/account');
			return;
		}
		else 
		{
			return false;
		}
	}
	
	public function goBackCart()
	{
		
		if (Mage::getSingleton('core/session')->getGoBackCart())
		{
			echo Mage::app()->getResponse()->setRedirect(Mage::helper('redirectedlogin')->getRedirectedUrl());
			return;
		}
	}
}
