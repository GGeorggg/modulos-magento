<?php
/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Banner
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Uni_Banner_Block_Adminhtml_Group_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _getEffects(){
		$effectsCollection = Mage::getModel('banner/effects')->getCollection();
		$effects = array();
		
		foreach($effectsCollection as $effect)
		{
			$effects[] = array(
				'value' => $effect->getEffectId(),
                'label' => Mage::helper('banner')->__($effect->getEffectName()),
            );				
		}
		
		return $effects ;
		
	}
	
	protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('group_form', array('legend' => Mage::helper('banner')->__('Item information')));

        $fieldset->addField('group_name', 'text', array(
            'label' => Mage::helper('banner')->__('Banner Group Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'group_name',
        ));

        if (Mage::registry('group_data')->getId() == null) {
            $fieldset->addField('group_code', 'text', array(
                'label' => Mage::helper('banner')->__('Banner Group Code'),
                'class' => 'required-entry',
                'name' => 'group_code',
                'required' => true,
            ));
        }
		
		$fieldset->addField('width_container', 'text', array(
            'label' => Mage::helper('banner')->__('Width Container'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'width_container',
        ));
		
		$fieldset->addField('width_banner', 'text', array(
            'label' => Mage::helper('banner')->__('Width Banner'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'width_banner',
        ));
		
		$fieldset->addField('height_banner', 'text', array(
            'label' => Mage::helper('banner')->__('Height Banner'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'height_banner',
        ));
		
		$fieldset->addField('background', 'text', array(
            'label' => Mage::helper('banner')->__('Background'),
            'name' => 'background',
        ));
		
		$fieldset->addField('filename', 'image', array(
			'label' => Mage::helper('banner')->__('Background Image'),
			'required' => false,
			'name' => 'filename',
		));
		
		$fieldset->addField('background_repeat', 'select', array(
            'label' => Mage::helper('banner')->__('Background Repeat'),
            'type' => 'banner',
            'name' => 'background_repeat',
			'values' => array(
				array(
					'value' => 'no-repeat',
					'label' => 'No Repeat',
				),
				array(
					'value' => 'repeat-x',
					'label' => 'Repeat x',
				),
				array(
					'value' => 'repeat-y',
					'label' => 'Repeat y',
				),
				array(
					'value' => 'repeat',
					'label' => 'Repeat Both',
				),
			),
        ));
		
		$fieldset->addField('effectgroup_fk', 'select', array(
            'label' => Mage::helper('banner')->__('Effect'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'effectgroup_fk',
			'values' => $this->_getEffects(),
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

        if (Mage::getSingleton('adminhtml/session')->getGroupData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getGroupData());
            Mage::getSingleton('adminhtml/session')->setGroupData(null);
        } elseif (Mage::registry('group_data')) {
            $form->setValues(Mage::registry('group_data')->getData());
        }
        return parent::_prepareForm();
    }

}