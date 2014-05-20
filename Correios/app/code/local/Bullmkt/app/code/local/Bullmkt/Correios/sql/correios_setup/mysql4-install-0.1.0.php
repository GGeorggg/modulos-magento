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

/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();

// Add volume to prduct attribute set
$codigo = 'volume_comprimento';
$config = array(
                'position' => 1,
                'required'=> 0,
                'label' => 'Comprimento (cm)',
                'type' => 'int',
                'input'=>'text',
                'apply_to'=>'simple,bundle,grouped,configurable',
                'note'=>'Comprimento da embalagem do produto (Para cálculo de PAC, mínimo de 16)'
            );

$setup->addAttribute('catalog_product', $codigo , $config);

// Add volume to prduct attribute set
$codigo = 'volume_altura';
$config = array(
                'position' => 1,
                'required'=> 0,
                'label' => 'Altura (cm)',
                'type' => 'int',
                'input'=>'text',
                'apply_to'=>'simple,bundle,grouped,configurable',
                'note'=>'Altura da embalagem do produto (Para cálculo de PAC, mínimo de 2)'
            );

$setup->addAttribute('catalog_product', $codigo , $config);

// Add volume to prduct attribute set
$codigo = 'volume_largura';
$config = array(
                'position' => 1,
                'required'=> 0,
                'label' => 'Largura (cm)',
                'type' => 'int',
                'input'=>'text',
                'apply_to'=>'simple,bundle,grouped,configurable',
                'note'=>'Largura da embalagem do produto (Para cálculo de PAC, mínimo de 11)'
            );

$setup->addAttribute('catalog_product', $codigo , $config);

$installer->endSetup();
