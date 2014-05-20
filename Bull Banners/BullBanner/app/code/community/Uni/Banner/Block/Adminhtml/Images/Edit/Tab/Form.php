<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Banner
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Banner_Block_Adminhtml_Images_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    
	protected function _getAllGroups(){
		$groupsCollection = Mage::getModel('banner/group')->getCollection();
		$groups = array();
		
		foreach($groupsCollection as $group)
		{
			$groups[] = array(
				'value' => $group->getGroupId(),
                'label' => Mage::helper('banner')->__($group->getGroupName()),
            );				
		}
		
		return $groups ;
		
	}
	
	protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('images_form', array('legend' => Mage::helper('banner')->__('Item information')));
        $version = substr(Mage::getVersion(), 0, 3);
        //$config = (($version == '1.4' || $version == '1.5') ? "'config' => Mage::getSingleton('banner/wysiwyg_config')->getConfig()" : "'class'=>''");

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('banner')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));
		
		$fieldset->addField('filename', 'image', array(
            'label' => Mage::helper('banner')->__('Image'),
            'required' => false,
            'name' => 'filename',
        ));

        $fieldset->addField('link', 'text', array(
            'label' => Mage::helper('banner')->__('Web Url'),
            'name' => 'link',
        ));

        $fieldset->addField('link_target', 'select', array(
            'label' => Mage::helper('banner')->__('Target'),
            'name' => 'link_target',
			'values' => array(
				array(
					'value' => '_blank',
					'label' => 'New Page',
				),
				array(
					'value' => '_self',
					'label' => 'Parent Page',
				),
			),
        ));
		
		$fieldset->addField('sort_order', 'text', array(
            'label' => Mage::helper('banner')->__('Sort Order'),
            'name' => 'sort_order',
        ));
		
		$fieldset->addField('entity_fk', 'text', array(
			'name' => 'entity_fk',
            'label' => Mage::helper('banner')->__('Product Sku'),
            'required' => false,
        ));
		
		$fieldset->addField('description', 'editor', array( 
		'name' => 'description', 
		'label' => Mage::helper('banner')->__('Content'), 
		'title' => Mage::helper('banner')->__('Content'), 
		'style' => 'width:600px; height:250px;',
		'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(), 
		'wysiwyg' => true, 
		'required' => false, 
		));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('banner')->__('Status'),
            'class' => 'required-entry',
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('banner')->__('Disabled'),
                ),
            ),
        ));
		
		$fieldset->addField('group_fk', 'select', array(
            'label' => Mage::helper('banner')->__('Group'),
            'class' => 'required-entry',
            'name' => 'group_fk',
            'values' => $this->_getAllGroups(),
        ));

        if (Mage::getSingleton('adminhtml/session')->getImagesData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getImagesData());
            Mage::getSingleton('adminhtml/session')->setImagesData(null);
        } elseif (Mage::registry('images_data')) {
            $form->setValues(Mage::registry('images_data')->getData());
        }
        return parent::_prepareForm();
    }

}