<?php
/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Banner
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Banner_Block_Adminhtml_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('group_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('banner')->__('Banner Group Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('banner')->__('Banner Group'),
            'alt' => Mage::helper('banner')->__('Banner Group'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_group_edit_tab_form')->toHtml(),
        ));

        $this->addTab('grid_section', array(
            'label' => Mage::helper('banner')->__('Images'),
            'alt' => Mage::helper('banner')->__('Images'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_group_edit_tab_gridimages')->toHtml(),
        ));
		
        return parent::_beforeToHtml();
    }

}