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
 * @package     Bullmkt_RemarketingDinamico
 * @copyright   Copyright (c) 2013 Bull Marketing <http://www.bullmarketing.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      Leandro Rosa <dev.leandrorosa@gmail.com>
 *
 */

class Bullmkt_RemarketingDinamico_Block_Remarketing extends Mage_Core_Block_Template
{
    protected function _getPageType()
    {
        return $this->getRequest()->getControllerName();
    }
    
	protected function _getProduct()
    {
        return Mage::registry('current_product');
    }
    
    protected function _getCategory()
    {
        Mage::registry('current_category');
    }
	
	protected function _getTagParams()
	{
		$result = array();
		
		if ($this->getProductId())
			$result['ecomm_prodid'] = $this->getProductId();
			
		if ($this->getPageType())
			$result['ecomm_pagetype'] = $this->getPageType();
			
		if ($this->getTotalValue())
			$result['ecomm_totalvalue'] = $this->getTotalValue();
		
		return $result;
	}
	
	protected function _getCartProductsIds()
	{
		$items = array();
		foreach(Mage::getSingleton('checkout/session')->getQuote()->getAllItems() as $item)
		{
			$product = Mage::getModel('catalog/product')->load($item->getProductId());
			if( $product->getTypeId() == 'simple' ){
				$items[] = $item->getProductId();
			}
		}
		
		return $items;
	}
	
	protected function _getCartProductsSkus()
	{
		$items = array();
		foreach(Mage::getSingleton('checkout/session')->getQuote()->getAllItems() as $item)
		{
			$product = Mage::getModel('catalog/product')->load($item->getProductId());
			if( $product->getTypeId() == 'simple' ){
				$items[] = $item->getSku();
			}
		}
		
		return $items;
	}
	
	public function getTagParams()
	{
		$result = '';
		foreach($this->_getTagParams() as $key => $value)
		{
			$result .= $key . " : '" . $value . "',";
		}
		
		return substr($result,0,-1);
	}
    
	public function isEnabled()
    {
        return Mage::getStoreConfig('google/bullremarketing/active', Mage::app()->getStore());
    }
	
	public function getProductPrice()
	{
		if ($this->_getPageType() == 'product')
        {
            return $this->_getProduct()->getFinalPrice();
        }
	}
	
	public function getProductName()
	{
		if ($this->_getPageType() == 'product')
        {
            return $this->_getProduct()->getName();
        }
	}

    public function getProductId()
    {
        if (Mage::getStoreConfig('google/bullremarketing/use_to_id', Mage::app()->getStore()) == 2)
        {
            if ($this->_getPageType() == 'product')   
            {
                return $this->_getProduct()->getId();
            }
			if ($this->_getPageType() == 'cart')
			{
				$products = implode(',',$this->_getCartProductsIds());
				return $products;
			}
        }
        else
        {
            if ($this->_getPageType() == 'product')   
            {
                return $this->_getProduct()->getSku();
            }
			if ($this->_getPageType() == 'cart')
			{
				$products = implode(',',$this->_getCartProductsSkus());
				return $products;
			}
        }
    }
    
    public function getPageType()
    {
        if ($this->_getPageType() == 'product')
        {
            return 'product';
        }
        else if ($this->_getPageType() == 'category')
        {
            return 'category';
        }
        else if ($this->_getPageType() == 'result')
        {
            return 'searchresults';
        }
        else if ($this->_getPageType() == 'cart')
        {
            return 'cart';
        }
        else if ($this->_getPageType() == 'success')
        {
            return 'purchase';
        }
        else if (Mage::getBlockSingleton('page/html_header')->getIsHomePage())
        {
            return 'home';
        }
        else
        {
            return 'other';
        }
    }
    
	
	public function getTotalValue()
    {
        if ($this->_getPageType() == 'cart')
        {
            return Mage::getSingleton('checkout/cart')->getQuote()->getSubtotal();
        }
    }
    
    public function getConversionId()
    {
        return Mage::getStoreConfig('google/bullremarketing/google_conversion_id',Mage::app()->getStore());
    }
    
    public function getConversionLabel()
    {
        return Mage::getStoreConfig('google/bullremarketing/google_conversion_label',Mage::app()->getStore());
    }
    
    public function isRemarketingOnly()
    {
        if ( Mage::getStoreConfig('google/bullremarketing/google_remarketing_only',Mage::app()->getStore()))
        {
            return 'true';
        }
        else
        {
            return 'false';
        }
    }
}