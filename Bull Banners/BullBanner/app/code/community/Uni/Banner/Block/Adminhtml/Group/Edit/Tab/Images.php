<?php
/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Banner
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Banner_Block_Adminhtml_Group_Edit_Tab_Images extends Uni_Banner_Block_Adminhtml_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('imagesLeftGrid');
        $this->setDefaultSort('image_id');
        $this->setUseAjax(true);
    }

    public function getGroupData() {
        return Mage::registry('group_data');
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('banner/images')->getCollection()->addFilter('group_fk', $this->getGroupData()->getGroupId());
        $collection->getSelect()->order('image_id');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns() {

        $this->addColumn('image_id', array(
            'header' => Mage::helper('catalog')->__('ID'),
            'sortable' => true,
            'width' => '50',
            'align' => 'center',
            'index' => 'image_id'
        ));

        $this->addColumn('filename', array(
            'header' => Mage::helper('banner')->__('Image'),
            'align' => 'center',
            'index' => 'filename',
            'type' => 'banner',
            'escape' => true,
            'sortable' => false,
            'width' => '150px',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('catalog')->__('Title'),
            'index' => 'title',
            'align' => 'left',
        ));

        $this->addColumn('link', array(
            'header' => Mage::helper('banner')->__('Link'),
            'width' => '200px',
            'index' => 'link',
        ));
        
        $this->addColumn('sort_order', array(
            'header' => Mage::helper('banner')->__('Sort Order'),
            'width' => '80px',
            'index' => 'sort_order',
            'align' => 'center',
        ));
        return parent::_prepareColumns();
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/imagesgrid', array('_current' => true));
    }

    protected function _getSelectedBanners() {
		return Mage::getModel('banner/images')->getCollection()->addFilter('group_fk', $this->getGroupData()->getGroupId());
    }

}

?>