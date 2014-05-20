<?php
/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Banner
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Banner_Block_Adminhtml_Effects_Grid extends Uni_Banner_Block_Adminhtml_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('effectsGrid');
        $this->setDefaultSort('effect_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('banner/effects')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('effect_id', array(
            'header' => Mage::helper('banner')->__('ID'),
            'align' => 'center',
            'width' => '30px',
            'index' => 'effect_id',
        ));

        $this->addColumn('effect_name', array(
            'header' => Mage::helper('banner')->__('Effect Name'),
            'align' => 'center',
            'width' => '150px',
			'index' => 'effect_name',
        ));

        $this->addColumn('action',
                array(
                    'header' => Mage::helper('banner')->__('Action'),
                    'width' => '80',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => Mage::helper('banner')->__('Edit'),
                            'url' => array('base' => '*/*/edit'),
                            'field' => 'id'
                        )
                    ),
                    'filter' => false,
                    'sortable' => false,
                    'index' => 'stores',
                    'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}