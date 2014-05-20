<?php
/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Banner
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Banner_Block_Adminhtml_Group_Edit_Tab_Gridimages extends Mage_Adminhtml_Block_Widget_Container {

    /**
     * Set template
     */
    public function __construct() {
        parent::__construct();
        $this->setTemplate('unibanner/banners.phtml');
    }

    public function getTabsHtml() {
        return $this->getChildHtml('tabs');
    }

    /**
     * Prepare button and grid
     *
     */
    protected function _prepareLayout() {
        $this->setChild('tabs', $this->getLayout()->createBlock('banner/adminhtml_group_edit_tab_images', 'group.grid.images'));
        return parent::_prepareLayout();
    }

    public function getGroupData() {
        return Mage::registry('group_data');
    }
}
