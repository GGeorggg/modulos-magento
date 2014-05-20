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
 
class Bullmkt_Correios_Block_Adminhtml_Update_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('updateGrid');
        $this->setDefaultSort('id_correios');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('correios/updates')->updateCarrierTable();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id_correios', array(
            'header' => Mage::helper('correios')->__('ID'),
            'align' => 'center',
            'width' => '30px',
            'index' => 'id_correios',
        ));

        $this->addColumn('service_name', array(
            'header' => Mage::helper('correios')->__('Service Name'),
            'align' => 'left',
            'index' => 'nome',
        ));
		
		$this->addColumn('region', array(
            'header' => Mage::helper('correios')->__('Region'),
            'index' => 'regiao',
        ));
		
		$this->addColumn('beginzipcode', array(
            'header' => Mage::helper('correios')->__('Begin Zip Code'),
            'index' => 'cep_destino_fim',
			'type'	=> 'number',
        ));

        $this->addColumn('lastzipcode', array(
            'header' => Mage::helper('correios')->__('Last Zip Code'),
            'index' => 'cep_destino_fim',
			'type'	=> 'number',
        ));

        $this->addColumn('price', array(
            'header' => Mage::helper('correios')->__('Price'),
            'width' => '150px',
            'index' => 'valor',
			'type'	=> 'currency',
        ));        

        $this->addColumn('action',
                array(
                    'header' => Mage::helper('correios')->__('Action'),
                    'width' => '80',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => Mage::helper('correios')->__('Update'),
                            'url' => array('base' => '*/*/update'),
                            'field' => 'id'
                        )
                    ),
                    'filter' => false,
                    'sortable' => false,
                    'index' => 'stores',
                    'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('correios')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('correios')->__('XML'));

        return parent::_prepareColumns();
    }

	protected function _prepareMassaction() {
        $this->setMassactionIdField('id_correios');
        $this->getMassactionBlock()->setFormFieldName('correios');

        $this->getMassactionBlock()->addItem('update', array(
            'label' => Mage::helper('correios')->__('Update'),
            'url' => $this->getUrl('*/*/massUpdate'),
            'confirm' => Mage::helper('correios')->__('Are you sure?')
        ));

        return $this;
    }
}