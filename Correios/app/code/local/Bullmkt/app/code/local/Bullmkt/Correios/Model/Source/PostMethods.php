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

class Bullmkt_Correios_Model_Source_PostMethods
{

    public function toOptionArray()
    {
        return array(
            array('value'=>40010, 'label'=>Mage::helper('adminhtml')->__('Sedex Sem Contrato (40010)')),
            array('value'=>40096, 'label'=>Mage::helper('adminhtml')->__('Sedex Com Contrato (40096)')),
            array('value'=>81019, 'label'=>Mage::helper('adminhtml')->__('E-Sedex Com Contrato (81019)')),
            array('value'=>41106, 'label'=>Mage::helper('adminhtml')->__('PAC Sem Contrato (41106)')),
            array('value'=>41068, 'label'=>Mage::helper('adminhtml')->__('PAC Com Contrato (41068)')),
            array('value'=>40215, 'label'=>Mage::helper('adminhtml')->__('Sedex 10 (40215)')),
            array('value'=>40290, 'label'=>Mage::helper('adminhtml')->__('Sedex HOJE (40290)')),
            array('value'=>40045, 'label'=>Mage::helper('adminhtml')->__('Sedex a Cobrar (40045)')),
        );
    }

}
