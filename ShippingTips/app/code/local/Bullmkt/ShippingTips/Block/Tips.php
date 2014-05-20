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
class Bullmkt_ShippingTips_Block_Tips extends Mage_Core_Block_Template
{
    protected $_datarules = array();
    protected $_totalBefore;
    protected $_minimum;
    protected $_maximum;
    
    protected function _getModel()
    {
        return Mage::getModel('shippingtips/tips');
    }
    
    public function isEnabled()
    {
        return Mage::getStoreConfig('bullmkt/shippingtips/active', Mage::app()->getStore());
    }
    
    protected function _calculatePostCode($rule)
    {
        $conditions = $this->_getConditions($rule);
        
        if($conditions['attribute'] == 'base_subtotal')
        {
            if($this->_getTotalValue() < $conditions['value'])
            {
                return Mage::helper('core')->currency($conditions['value'] - $this->_getTotalValue());
            }
        }
    }
    
    protected function _getConditions($id)
    {
        $rule = Mage::getModel('salesrule/rule')->load($id); 
        
 
        $conditions = $rule->getConditions()->asArray();
		/*echo '<pre>';
		print_r($conditions);
		echo '</pre>';*/
		return $conditions;
    }
    
    public function getConditionPostCode($id)
    {
        $resource = $this->_getConditions($id);

        foreach($resource['conditions'] as $conditions)
        {
            if($conditions['attribute'] == 'postcode')
            {                
                if($conditions['operator'] == '>=')
                {
                    $this->_minimum = $conditions['value'];
                }

                if($conditions['operator'] == '<=')
                {
                    $this->_maximum = $conditions['value'];
                }

                if($this->_getConditionPostCode() <= $this->_maximum && $this->_getConditionPostCode() >= $this->_minimum)
                {
                    return true;
                    /*print_r('<p>'. $this->_getConditionPostCode() .' - '. $this->_maximum .'</p>');
                    print_r('<p>'. $this->_getConditionPostCode() .' - '. $this->_minimum .'</p>');*/
                }
                
                if(!$this->_maximum && !$this->_minimum)
                {
                    return;
                    
                }
            }
        }
    }
    protected 
            function _getCartRules()
    {
        $resource = Mage::getResourceModel('salesrule/rule_collection')->load();
        return $resource->getAllIds();
    }
    
    public function getCartRules()
    {
        foreach($this->_getCartRules() as $id)
        {
            $conditionscollection = $this->_getConditions($id);
            
            foreach($conditionscollection as $conditions)
            {   
                foreach($conditions as $condition)
                {
                    if($condition['attribute'] == 'postcode')
                    {
                        if($condition['operator'] == '>=')
                        {
                            $this->_minimum = $condition['value'];
                        }

                        if($condition['operator'] == '<=')
                        {
                            $this->_maximum = $condition['value'];
                        }

                        if($this->_getConditionPostCode() <= $this->_maximum && $this->_getConditionPostCode() >= $this->_minimum)
                        {
                            $data = Mage::getModel('salesrule/rule')->load($id);
                            $this->_datarules[$id] =  $data->getData();
                            $this->_minimum  = 9999999999;
                            $this->_maximum = 0;
                        }
                    }
                }
            } 
        }
        
        return $this->_datarules;
    }
    
    protected function _getQuote()
    {
        return Mage::getSingleton('checkout/cart')->getQuote();
    }
    
    protected function _getTotalValue()
    {
        return $this->_getQuote()->getSubtotal();
    }
    
    protected function _getConditionPostCode()
    {
        return Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getData('postcode');
    }
    
    public function getShippingPrices()
    {
        $quote = $this->_getQuote();
        $quote->getShippingAddress()->getShippingMethod();
        $quote->getShippingAddress()->setCollectShippingRates(true);
        $quote->getShippingAddress()->collectShippingRates();
        $rates = $quote->getShippingAddress()->getAllShippingRates();
        $allowed_rates = array(); 
        foreach ($rates as $rate) 
        {
            array_push($allowed_rates,$rate->getData('price'));
        }
        return Mage::helper('core')->currency(max($allowed_rates));
    }
    
    public function getConditionBaseSubtotal($rule)
    {
        $resource = $this->_getConditions($rule);

        $this->getShippingPrices();
		foreach($resource['conditions'] as $conditions)
		{
			if($conditions['attribute'] == 'base_subtotal')
			{
				$this->_totalBefore = $conditions['value'] - $this->_getTotalValue();
				Mage::getSingleton('core/session')->setTotalBefore($this->_totalBefore);
				
				if($this->_totalBefore > $this->getMinimumValue())
					return; 
			
				if($this->_getTotalValue() < $conditions['value'])
				{
					return Mage::helper('core')->currency($this->_totalBefore);
				}
        	}
		}
    }
    
    public function getMinimumValue()
    {
         return Mage::getStoreConfig('bullmkt/shippingtips/minimum_value', Mage::app()->getStore());
    }
    
    public function getFreeShippingProducts()
    {
        return $this->_getModel()->getProducts(Mage::getSingleton('core/session')->getTotalBefore());
    }
    
}