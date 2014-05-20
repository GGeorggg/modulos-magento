<?php
/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Banner
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Banner_Block_Banner extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

	public function getImagesCollection($group){
		return Mage::getModel('banner/images')->getCollection()->addFilter('group_fk',$group)->setOrder('sort_order','ASC');
	}
	
	public function getCurrencyEffect($effect){
		return Mage::getModel('banner/effects')->load($effect);
	}
	
	public function getCurrencyGroup($group){
		return Mage::getModel('banner/group')->load($group);
	}
	
	public function getCurrencyProduct($product){
		return Mage::getModel('catalog/product')->loadByAttribute('sku',$product);
	}
	
    public function getDataByGroupCode($groupCode){
        return Mage::getModel('banner/group')->getDataByGroupCode($groupCode);
    }
	
    protected function checkDir($directory) {
        if (!is_dir($directory)) {
            umask(0);
            mkdir($directory, 0777,true);
            return true;
        }
    }

}