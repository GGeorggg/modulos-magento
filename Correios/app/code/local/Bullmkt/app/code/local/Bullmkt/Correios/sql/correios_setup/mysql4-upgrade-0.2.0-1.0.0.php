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

$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$installer->deleteConfigData('carriers/correios/urlmethod');

$sql = "select value from ".$installer->getTable('core/config_data')." where path='carriers/correios/postmethods'";
$methods = explode(',', $connection->fetchOne($sql));
foreach($methods as $key => $method){
    if($method == '41025'){
        unset($methods[$key]);
    }
}
if(count($methods) <= 0){
    $methods[] = '41106';
}
$installer->setConfigData('carriers/correios/postmethods', implode(',', $methods));

$sql = "select value from ".$installer->getTable('core/config_data')." where path='carriers/correios/free_method'";
if($connection->fetchOne($sql) == '41025'){
    $installer->setConfigData('carriers/correios/free_method', '41106');
}

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->updateAttribute('catalog_product', 'volume_comprimento', 'note', 'Comprimento da embalagem do produto (Para cálculo dos Correios)');
$setup->updateAttribute('catalog_product', 'volume_altura', 'note', 'Altura da embalagem do produto (Para cálculo dos Correios)');
$setup->updateAttribute('catalog_product', 'volume_largura', 'note', 'Largura da embalagem do produto (Para cálculo dos Correios)');

$installer->endSetup();