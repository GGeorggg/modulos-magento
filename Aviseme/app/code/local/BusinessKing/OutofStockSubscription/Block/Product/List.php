<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product list
 *
 * @category   BusinessKing
 * @package    BusinessKing_OutofStockSubscription
 * @author     Leandro Anderson <leandro@bullmarketing.com.br>
 */
 
class BusinessKing_OutofStockSubscription_Block_Product_List extends Mage_Catalog_Block_Product_List {
	
	public function getOutStock($product){
	
		$_storeId = Mage::app()->getStore()->getId();
		$_isActive = Mage::getStoreConfig('outofstocksubscription/mail/active', $_storeId);
		
		if(!$product->isSaleable() && $_isActive) {
			return $this->getOutStockLinKProduct($product);	
		}
				
	}
	
	protected function getOutStockLinKProduct($product) {
		$link = $this->getUrl('outofstocksubscription/register/form/product/'.$product->getId());
		$html = $this->__("<a href='".$link."' id='outlightbox-%s' class='outlightbox-btn' title='Avise-me quando o produto %s estiver disponivel'>Avise quando estiver disponivel</a>", $product->getId(), $product->getName());
		$html .="
			
			<script type='text/javascript'>
			
				jQuery(document).ready(function(e) {
       
					jQuery('#outlightbox-".$product->getId()."').fancybox({
						'width' : 450,
						'height': 300,
						'type'  : 'iframe'
					});
				});
			</script>
			
			
			
		";
		
		return $html;
	}
}