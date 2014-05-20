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
 * @category   BullMarketing
 * @package    BullMarketing_Bullrewrite
 * @author     Leandro Anderson <leandro@bullmarketing.com.br>
 */ 
 ?>
 
<?php

class Bullmkt_Bullquotes_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getNumberQuotes($capital)
	{

        $numberQuotesMax = Mage::getStoreConfig('bullquotes/settings/number_quotes');
		$valueMin	 = Mage::getStoreConfig('bullquotes/settings/value_min');
		$total = $capital;
		
		$nParcelas = $numberQuotesMax;
		//verifica o valor mínimo permitido para cada parcela
	
        if (!empty($valueMin) && is_numeric($valueMin))
		{
            $numberQuotesMax = floor($total / $valueMin);
			
			if ($numberQuotesMax < $nParcelas) 
			{
				$nParcelas = $numberQuotesMax;
			}
		}
        
		return $nParcelas;	
    }
	
    public function getValueQuote($capital, $parcela)
	{
		
        $taxa  = Mage::getStoreConfig('bullquotes/settings/taxa');
		$total = $capital;
		
		if(!is_numeric($total) || $total <= 0)
		{
            return false;
		}
	
        if((int)$parcela != $parcela)
		{
            return false;
		}
	
        if(!is_numeric($taxa) || $taxa < 0)
		{
            return false;
		}
	
        $taxa = $taxa / 100;
        $denominador = 0;
	
        if($parcela > 1)
		{
            for($i=1; $i<=$parcela; $i++)
			{
                $denominador += 1/pow(1+$taxa,$i);
            }
		}
		
		else
		{
            $denominador = 1;
		}
	
		$valorParcelado = ($total/$denominador);
		
		return $valorParcelado;
		 
    }
	
	public function getListHtml($product)
	{
		$qty	= $this->getNumberQuotes($product->getFinalPrice());
		$vlr	= Mage::helper('core')->currency( $this->getValueQuote( $product->getFinalPrice(), $qty ) );
		$fullVlr = Mage::helper('core')->currency($product->getFinalPrice());
		
		$html 	= '<div class="quote-box">';
		
		$html 	.= '<div class="in-cart">';
		$html	.= $this->__('<strong>%sx</strong> de <strong>%s</strong>', $qty, $vlr );
		$html 	.= '</div>';
		
		$html 	.= '<div class="in-money">';
		$html	.= $this->__('ou %s no boleto', $fullVlr);
		$html 	.= '</div>';
		
		$html 	.= '</div>';
		
		return $html;
	}
}