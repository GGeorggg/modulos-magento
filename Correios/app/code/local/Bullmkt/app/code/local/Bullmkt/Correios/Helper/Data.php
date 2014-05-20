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
 * @package     Bullmkt_Correios
 * @copyright   Copyright (c) 2013 Bull Marketing <http://www.bullmarketing.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * 
 * @author		Leandro Rosa <dev.leandrorosa@gmail.com>
 */

class Bullmkt_Correios_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function accessCorreiosWs($item)
	{
		$cep_origem 	= Mage::getStoreConfig('shipping/origin/postcode',Mage::app()->getStore());
		$wsurl 			= 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?StrRetorno=xml';
		$nCdEmpresa 	= Mage::getStoreConfig('carriers/correios/business_code',Mage::app()->getStore());
		$sDsSenha		= Mage::getStoreConfig('carriers/correios/business_password',Mage::app()->getStore());
		$nVlComprimento	= Mage::getStoreConfig('carriers/correios/min_length',Mage::app()->getStore());
		$nVlAltura		= Mage::getStoreConfig('carriers/correios/min_height',Mage::app()->getStore());
		$nVlLargura		= Mage::getStoreConfig('carriers/correios/min_width',Mage::app()->getStore());
		
		$url = $wsurl."&nCdEmpresa=".$nCdEmpresa."&sDsSenha=".$sDsSenha."&nCdFormato=1&nCdServico=".$item->getServico()."&nVlComprimento=".$nVlComprimento."&nVlAltura=".$nVlAltura."&nVlLargura=".$nVlLargura."&sCepOrigem=".$cep_origem."&sCdMaoPropria=N&sCdAvisoRecebimento=N&nVlValorDeclarado=0&nVlPeso=".$item->getPeso()."&sCepDestino=".$item->getCepDestRef();
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		ob_start();
		curl_exec($ch);
		curl_close($ch);
		
		$content = ob_get_contents();
		
		ob_end_clean();
		
		return $content;
	}

}
