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
 * @package     Bullmkt_ContactsChoise
 * @copyright   Copyright (c) 2013 Bull Marketing <http://www.bullmarketing.com.br>
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      Leandro Rosa <dev.leandrorosa@gmail.com>
 *
 */

class Bullmkt_ContactsChoise_Block_Adminhtml_Receiver_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct() {
        parent::__construct();
        $this->setId('receiverGrid');
        $this->setDefaultSort('receiver_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('contactschoise/receiver')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('receiver_id', array(
            'header' => Mage::helper('contactschoise')->__('ID'),
            'align' => 'center',
            'width' => '30px',
            'index' => 'receiver_id',
        ));

        $this->addColumn('receiver_name', array(
            'header' => Mage::helper('contactschoise')->__('Receiver Name'),
            'align' => 'center',
            'width' => '150px',
			'index' => 'receiver_name',
        ));
        
        $this->addColumn('receiver_email', array(
            'header' => Mage::helper('contactschoise')->__('Receiver Email'),
            'align' => 'center',
            'width' => '150px',
			'index' => 'receiver_email'
        ));

        $this->addColumn('action',
                array(
                    'header' => Mage::helper('contactschoise')->__('Action'),
                    'width' => '80',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => Mage::helper('contactschoise')->__('Edit'),
                            'url' => array('base' => '*/*/edit'),
                            'field' => 'id'
                        ),
                        array(
                            'caption' => Mage::helper('contactschoise')->__('Delete'),
                            'url' => array('base' => '*/*/delete'),
                            'field' => 'id'
                        ),
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